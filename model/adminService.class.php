<?php

require_once __SITE_PATH . '/app/database/mongodb.class.php';
require_once __SITE_PATH . '/model/sight.class.php';
require_once __SITE_PATH . '/model/sightService.class.php';

use Laudis\Neo4j\Authentication\Authenticate;
use Laudis\Neo4j\Basic\Driver;

class AdminService {

    private $mongoAttraction = null;
    private $neo4jSession = null;

    private $sightService = null;
    public function __construct(){}

    private function getSightService(){
        if($this->sightService === null){
            $this->sightService = new SightService();
        }
        return $this->sightService;
    }
    private function getNeoSession(){
        if($this->neo4jSession === null){
            require_once __SITE_PATH . '/app/database/neo4j.class.php';
            $this->neo4jSession = Neo4jDB::getConnection();
        }
        return $this->neo4jSession;
    }
    private function getMongoAttractions(){

        if($this->mongoAttraction === null){
            require_once __SITE_PATH . '/app/database/mongodb.class.php';
            $mongo_Database = mongoDB::getDatabase();
            $this->mongoAttraction = $mongo_Database->attractions;
        }
        return $this->mongoAttraction;
    }
    //obrisi
    function deleteMongoDB($delete){
        $collection = $this->getMongoAttractions();

        try {
            $filter = ["_id" => new MongoDB\BSON\ObjectId($delete)];	

            $collection->deleteOne($filter);            
        } catch (Exception $e) {
            exit();
        }
    }

    function deleteNeo4j($delete){
        $session = $this->getNeoSession();
        $param = ['id1' => new MongoDB\BSON\ObjectId($delete)];
        $query = 'MATCH (a:Attraction {id: $id1}) DETACH DELETE a;';
        $session->run($query, $param);
    }

    //stavi sliku na aws
    function processImageUpload(){
        require_once __SITE_PATH . '/app/start.php';
        if(isset($_FILES['slika'])) {
            $file = $_FILES['slika'];
            $name = $file['name'];
            $tmp_name = $file['tmp_name'];
            $extension = explode('.',$name);
            $extension = strtolower(end($extension));
            $key = md5((uniqid()));
            $tmp_file_name = "{$key}.{$extension}";
            $tmp_file_path = __SITE_PATH . "/tmp_files/{$tmp_file_name}";
            move_uploaded_file($tmp_name, $tmp_file_path);
            
            try {
                $s3->putObject([
                    'Bucket' => $config['s3']['bucket'],
                    'Key' => "{$name}",
                    'Body' => fopen($tmp_file_path, 'rb')
                ]);
                unlink($tmp_file_path);
            } catch(exception $e){
                die("There was an exception" . $e);
            }
        }
        else{
            error_log("Error nije dobro poslan file");
        }
    }

    //upload
    function addUploadToDatabases() : bool {
        require_once __SITE_PATH . '/vendor/autoload.php';
        require_once __SITE_PATH . '/app/database/mongodb.class.php';
        $collection = $this->getMongoAttractions();

        $naziv = $_POST['naziv'];
        $opis = $_POST['opis'];
        (int)$x_koordinata = $_POST['x-koordinata'];
        (int)$y_koordinata = $_POST['y-koordinata'];
        $image_path = $_FILES['slika'];
        

        $filter = ['name' => $naziv];
        $result_name = $collection->findOne($filter);

        $filter = ['x_coordinate' => $x_koordinata, 'y_coordinate' => $y_koordinata] ;
        $result_coord = $collection->findOne($filter);


        if ($result_name === null && $result_coord === null) {
            
            $this->processImageUpload();
            $id = new MongoDB\BSON\ObjectId();
            $document = [
                '_id' => $id,
                'name' => $naziv,
                'description' => $opis,
                'image_path' => $image_path['name'],
                'x_coordinate' => $x_koordinata,
                'y_coordinate' => $y_koordinata,
            ];
            $collection->insertOne($document);
            $this->addToNeo4j($id, $x_koordinata, $y_koordinata);
            return true;
        }
        else {
            return false;
        }
    }

    function addToNeo4j($addId , $x_koordinata, $y_koordinata){
        $session = $this->getNeoSession();

        $query = (string)'CREATE (n:Attraction {id: $addId, x_coordinate: $x_koordinata, y_coordinate: $y_koordinata});';
        $param = ['addId' => $addId, 'x_koordinata' => $x_koordinata, 'y_koordinata' => $y_koordinata ];
        $session->run($query, $param);

        // ovo možda ne radi zbog apoc plugina
        // $session->run('MATCH (a1:Attraction {id: $addId}), (a2:Attraction) WHERE a1.id <> a2.id
        //     WITH point({x: a1.x_coordinate, y: a1.y_coordinate}) AS point1, point({x: a2.x_coordinate, y: a2.y_coordinate}) AS point2
        //     WITH  apoc.spatial.distance(point1, point2) AS dist CREATE (a1)-[d:DISTANCE]->(a2) SET d.attribute = dist ' 
        // , $param) ;

        $session->run('MATCH (a1:Attraction {id: $addId}), (a2:Attraction) WHERE a1.id <> a2.id
            WITH sqrt((a1.x_coordinate - a2.x_coordinate)^2 + (a1.y_coordinate - a2.y_coordinate)^2) AS dist 
            CREATE (a1)-[d:DISTANCE]->(a2) SET d.attribute = dist ;' 
        , $param) ;
    }

    //update
    function updateName($id, $name) {
        $collection = $this->getMongoAttractions();

        $filter = ['_id' => new MongoDB\BSON\ObjectId($id)];
        $set = ['$set' => ['name' => $name]];
        $collection->updateOne($filter,$set);
    }

    function updateDescription($id, $desc) {
        $collection = $this->getMongoAttractions();

        $filter = ['_id' => new MongoDB\BSON\ObjectId($id)];
        $set = ['$set' => ['description' => $desc]];
        $collection->updateOne($filter,$set);
    }

    function updateImage($id, $image) {
        $this->processImageUpload();
        //promijeni u bazi ime slike
        $collection = $this->getMongoAttractions();

        $filter = ['_id' => new MongoDB\BSON\ObjectId($id)];
        $set = ['$set' => ['image_path' => $image]];
        $collection->updateOne($filter,$set);
    }

    function euclideanDistance($x1, $y1, $x2, $y2) {
        $distance = sqrt(pow($x2 - $x1, 2) + pow($y2 - $y1, 2));
        return $distance;
    }

    function updateCoordinates($id, $xcoord, $ycoord){
        $session = $this->getNeoSession();

        $collection = $this->getMongoAttractions();

        $id_ = new MongoDB\BSON\ObjectId($id);
        $filter = ['_id' => $id_];
        $set = ['$set' => ['x_coordinate' => $xcoord , 'y_coordinate' => $ycoord]];
        $collection->updateOne($filter,$set);

        $query1 = 'MATCH (a1:Attraction {id: $id1}) SET a1.x_coordinate = $x_coordinate , a1.y_coordinate = $y_coordinate';
        $params1 = ['id1' => $id, 'x_coordinate' => $xcoord, 'y_coordinate' => $ycoord ];
        $session->run($query1, $params1);

        $data = $this->getSightService()->getAllSights();

        foreach($data as $d) {
            $calcDist = $this->euclideanDistance($xcoord, $ycoord, $d->x_coord, $d->y_coord);

            $query1 = 'MATCH (a1:Attraction {id: $id1})-[d:DISTANCE]-(a2:Attraction {id: $id2}) WHERE a1.id <> a2.id SET d.attribute = $dist';
            $params1 = ['id1' => $id_, 'id2' => $d->id, 'dist' => $calcDist];
            $session->run($query1, $params1);
        }

    }

    function updateXCoordinate($id, $xcoord) {
        $session = $this->getNeoSession();

        $collection = $this->getMongoAttractions();

        $id_ = new MongoDB\BSON\ObjectId($id);
        $filter = ['_id' => $id_];
        $set = ['$set' => ['x_coordinate' => $xcoord]];
        $collection->updateOne($filter,$set);

        $query1 = 'MATCH (a1:Attraction {id: $id1} SET a1.x_coordinate = $x_coordinate';
        $params1 = ['id1' => $id, 'x_coordinate' => $xcoord ];
        $session->run($query1, $params1);

        $document = $collection->findOne($filter);
        $ycoord = $document['y_coordinate'];

        $data = $this->getSightService()->getAllSights();

        foreach($data as $d) {
            $calcDist = $this->euclideanDistance($xcoord, $ycoord, $d->x_coord, $d->y_coord);

            $query1 = 'MATCH (a1:Attraction {id: $id1})-[d:DISTANCE]-(a2:Attraction {id: $id2}) WHERE a1.id <> a2.id SET d.attribute = $dist';
            $params1 = ['id1' => $id_, 'id2' => $d->id, 'dist' => $calcDist];
            $session->run($query1, $params1);
        }  
    }

    function updateYCoordinate($id, $ycoord) {
        $session = $this->getNeoSession();

        $collection = $this->getMongoAttractions();

        $id_ = new MongoDB\BSON\ObjectId($id);
        $filter = ['_id' => $id_];
        $set = ['$set' => ['y_coordinate' => $ycoord]];
        $collection->updateOne($filter,$set);

        $query1 = 'MATCH (a1:Attraction {id: $id1} SET a1.y_coordinate = $y_coordinate';
        $params1 = ['id1' => $id, 'y_coordinate' => $ycoord ];
        $session->run($query1, $params1);

        $document = $collection->findOne($filter);
        $xcoord = $document['x_coordinate'];

        $data = $this->getSightService()->getAllSights();

        foreach($data as $d) {
            $calcDist = $this->euclideanDistance($xcoord, $ycoord, $d->x_coord, $d->y_coord);

            $query1 = 'MATCH (a1:Attraction {id: $id1})-[d:DISTANCE]-(a2:Attraction {id: $id2}) WHERE a1.id <> a2.id SET d.attribute = $dist';
            $params1 = ['id1' => $id_, 'id2' => $d->id, 'dist' => $calcDist];
            $session->run($query1, $params1);
        }
    }


}
?>