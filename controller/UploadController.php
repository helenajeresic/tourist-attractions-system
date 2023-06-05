<?php 

use Laudis\Neo4j\Authentication\Authenticate;
use Laudis\Neo4j\Basic\Driver;

class UploadController extends BaseController {
    public function index(){
        $this->registry->template->title = "Upload";
        $this->registry->template->error = false;
        $this->registry->template->show("upload");
    }

    public function processUpload(){
        $this->processImageUpload();
        $this->addUploadToMongo();
    }

    function processImageUpload(){
        require_once __SITE_PATH . '/app/start.php';
        if(isset($_FILES['slika'])) {
            $file = $_FILES['slika'];
            $name = $file['name'];
            $tmp_name = $file['tmp_name'];
            $extension = explode('.',$name);
            $extension =strtolower(end($extension));
            $key = md5((uniqid()));
            $tmp_file_name = "{$key}.{$extension}";
            $tmp_file_path = __SITE_PATH . "/tmp_files/{$tmp_file_name}";
            move_uploaded_file($tmp_name, $tmp_file_path);
            
            try {
                $s3->putObject([
                    'Bucket' => $config['s3']['bucket'],
                    'Key' => "{$name}",
                    'Body' => fopen($tmp_file_path, 'rb')//,
                    //'ACL' => 'public-read'
                ]);
                unlink($tmp_file_path);
            } catch(exception $e){
                die("There was an exception" . $e);
            }
            // } catch(S3Exception $e) {
            //     die("There was an error uploading that file");
            // }
        }
        else{
            error_log("Error nije dobro poslan file");
        }
    }

    function addUploadToMongo(){
        require_once __SITE_PATH . '/vendor/autoload.php';
        require_once __SITE_PATH . '/app/database/mongodb.class.php';
        $naziv = $_POST['naziv'];
        $opis = $_POST['opis'];
        $x_koordinata = $_POST['x-koordinata'];
        $y_koordinata = $_POST['y-koordinata'];
        $image_path = $_FILES['slika'];
        
        $mongo_Client = mongoDB::getCLient();
        $mongo_Database = mongoDB::getDatabase();
        $mongo_manager = mongoDB::getManager();

        $collection = $mongo_Database->attractions;
        $filter = ['Naziv' => $naziv];
        $result = $collection->findOne($filter);

        if ($result !== null) {
            echo "Atrakcija s imenom $naziv već postoji.";
        } else {
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
            $this->addToNeo4j($id);
        }


    }

    function addToNeo4j($addId){
        $config = require_once __SITE_PATH . '/app/config.php';

        $uri =  sprintf("http://{$username_mongo}:{$encodedPassword_mongo}@localhost:7474/", $password_mongo);
        $user_neo4j = $config['neo4j']['username'];
        $noe4j_password =  $config['neo4j']['password'];
        $auth = Authenticate::basic($user_neo4j, $noe4j_password);
        $driver = Driver::create($uri, authenticate: $auth);
        $session = $driver->createSession();

        $query = 'CREATE (a:Attraction {id: id1});';
        $param = ['id1' => $addId];
        $session->run($query, $param);
    }

}

?>