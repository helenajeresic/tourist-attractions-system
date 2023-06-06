<?php 

require_once 'model/sight.class.php';
require_once 'model/sightService.class.php';

use Laudis\Neo4j\Authentication\Authenticate;
use Laudis\Neo4j\Basic\Driver;

class UpdateController extends BaseController {
    public function index(){
        $this->registry->template->title = "Update";
        $this->registry->template->error = false;

        $ss = new SightService();
        $data = $ss->getAllSights();
        $this->registry->template->data = $data;

        $this->registry->template->show("update");
    }

    public function processUpdate() {
        require_once __SITE_PATH . '/app/database/mongodb.class.php';
        //zasto mi updata sve iako nisu postavljeni u postu
        if(isset($_POST['lang'])) {
            $selected = $_POST['lang'];
            if(isset($_POST['naziv'])) 
                $this->updateName($selected,$_POST['naziv']);

            if(isset($_POST['opis'])) 
                $this->updateDescription($selected, $_POST['opis']);

            if(isset($_POST['x-koordinata'])) 
                $this->updateXCoordinate($selected, (int) $_POST['x-koordinata']);
            
            if(isset($_POST['y-koordinata'])) 
                $this->updateYCoordinate($selected, (int) $_POST['y-koordinata']);

            if(isset($_FILES['slika'])) 
                $this->updateImage($selected, $_FILES['slika']);
        }  
    }

    function updateName($id, $name) {
        $mongo_Client = mongoDB::getCLient();
        $mongo_Database = mongoDB::getDatabase();
        $mongo_manager = mongoDB::getManager();
        
        $collection = $mongo_Database->attractions;

        $filter = ['_id' => new MongoDB\BSON\ObjectId($id)];
        $set = ['$set' => ['name' => $name]];
        $collection->updateOne($filter,$set);
    }

    function updateDescription($id, $desc) {
        $mongo_Client = mongoDB::getCLient();
        $mongo_Database = mongoDB::getDatabase();
        $mongo_manager = mongoDB::getManager();

        $collection = $mongo_Database->attractions;

        $filter = ['_id' => new MongoDB\BSON\ObjectId($id)];
        $set = ['$set' => ['description' => $desc]];
        $collection->updateOne($filter,$set);
    }

    function updateImage($id, $image) {
        $this->processImageUpload();
        //promijeni u bazi ime slike
        $mongo_Client = mongoDB::getCLient();
        $mongo_Database = mongoDB::getDatabase();
        $mongo_manager = mongoDB::getManager();
        
        $collection = $mongo_Database->attractions;

        $filter = ['_id' => new MongoDB\BSON\ObjectId($id)];
        $set = ['$set' => ['image_path' => $image]];
        $collection->updateOne($filter,$set);
    }

    function processImageUpload() {
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

    function euclideanDistance($x1, $y1, $x2, $y2) {
        $distance = sqrt(pow($x2 - $x1, 2) + pow($y2 - $y1, 2));
        return $distance;
    }

    function updateXCoordinate($id, $xcoord) {
        $config = require_once __SITE_PATH . '/app/config.php';

        $uri =  sprintf("http://{$username_mongo}:{$encodedPassword_mongo}@localhost:7474/", $password_mongo);
        $user_neo4j = $config['neo4j']['username'];
        $noe4j_password =  $config['neo4j']['password'];
        $auth = Authenticate::basic($user_neo4j, $noe4j_password);
        $driver = Driver::create($uri, authenticate: $auth);
        $session = $driver->createSession();

        $mongo_Client = mongoDB::getCLient();
        $mongo_Database = mongoDB::getDatabase();
        $mongo_manager = mongoDB::getManager();

        $collection = $mongo_Database->attractions;

        $id_ = new MongoDB\BSON\ObjectId($id);
        $filter = ['_id' => $id_];
        $set = ['$set' => ['x_coordinate' => $xcoord]];
        $collection->updateOne($filter,$set);

        $document = $collection->findOne($filter);
        $ycoord = $document['y_coordinate'];

        $ss = new SightService();
        $data = $ss->getAllSights();

        foreach($data as $d) {
            $calcDist = $this->euclideanDistance($xcoord, $ycoord, $d->__get('x_coord'), $d->__get('y_coord'));

            $query1 = 'MATCH (a1:Attraction {id: $id1})-[d:DISTANCE]->(a2:Attraction {id: $id2}) SET d.attribute = $dist';
            $params1 = ['id1' => $id_, 'id2' => $d->__get('id'), 'dist' => $calcDist];
            $session->run($query1, $params1);

            $query1 = 'MATCH (a1:Attraction {id: $id1})<-[d:DISTANCE]-(a2:Attraction {id: $id2}) SET d.attribute = $dist';
            $params1 = ['id1' => $id_, 'id2' => $d->__get('id'), 'dist' => $calcDist];
            $session->run($query1, $params1);
        }  
    }

    function updateYCoordinate($id, $ycoord) {
        $config = require_once __SITE_PATH . '/app/config.php';

        $uri =  sprintf("http://{$username_mongo}:{$encodedPassword_mongo}@localhost:7474/", $password_mongo);
        $user_neo4j = $config['neo4j']['username'];
        $noe4j_password =  $config['neo4j']['password'];
        $auth = Authenticate::basic($user_neo4j, $noe4j_password);
        $driver = Driver::create($uri, authenticate: $auth);
        $session = $driver->createSession();

        $mongo_Client = mongoDB::getCLient();
        $mongo_Database = mongoDB::getDatabase();
        $mongo_manager = mongoDB::getManager();

        $collection = $mongo_Database->attractions;

        $id_ = new MongoDB\BSON\ObjectId($id);
        $filter = ['_id' => $id_];
        $set = ['$set' => ['y_coordinate' => $ycoord]];
        $collection->updateOne($filter,$set);

        $document = $collection->findOne($filter);
        $xcoord = $document['x_coordinate'];

        $ss = new SightService();
        $data = $ss->getAllSights();

        foreach($data as $d) {
            $calcDist = $this->euclideanDistance($xcoord, $ycoord, $d->__get('x_coord'), $d->__get('y_coord'));

            $query1 = 'MATCH (a1:Attraction {id: $id1})-[d:DISTANCE]->(a2:Attraction {id: $id2}) SET d.attribute = $dist';
            $params1 = ['id1' => $id_, 'id2' => $d->__get('id'), 'dist' => $calcDist];
            $session->run($query1, $params1);

            $query1 = 'MATCH (a1:Attraction {id: $id1})<-[d:DISTANCE]-(a2:Attraction {id: $id2}) SET d.attribute = $dist';
            $params1 = ['id1' => $id_, 'id2' => $d->__get('id'), 'dist' => $calcDist];
            $session->run($query1, $params1);
        }
    }

}

?>