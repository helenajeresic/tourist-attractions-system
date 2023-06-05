<?php 

require_once 'model/sight.class.php';
require_once 'model/sightService.class.php';


use Laudis\Neo4j\Authentication\Authenticate;
use Laudis\Neo4j\Basic\Driver;

class deleteController extends BaseController {
    public function index(){
        $this->registry->template->title = "Delete";
        $this->registry->template->error = false;

        $ss = new SightService();
        $data = $ss->getAllSights();
        $this->registry->template->data = $data;

        $this->registry->template->show("delete");
    }

    public function processDelete(){
        if(isset($_POST['lang'])) {
            $selected = $_POST['lang'];
            //dodaj provjeru postoji li u bazi
            $this->deleteMongoDB($selected);
            $this->deleteNeo4j($selected);
        }
    }

    function deleteMongoDB($delete){
        require_once __SITE_PATH . '/app/database/mongodb.class.php';

        $mongo_Client = mongoDB::getCLient();
        $mongo_Database = mongoDB::getDatabase();
        $mongo_manager = mongoDB::getManager();

        $collection = $mongo_Database->attractions;
        
        try {
            $filter = ["_id" => new MongoDB\BSON\ObjectId($delete)];	

            $collection->deleteOne($filter);            
        } catch (Exception $e) {
            exit();
        }


    }

    function deleteNeo4j($delete){
        $config = require_once __SITE_PATH . '/app/config.php';

        $uri =  sprintf("http://{$username_mongo}:{$encodedPassword_mongo}@localhost:7474/", $password_mongo);
        $user_neo4j = $config['neo4j']['username'];
        $noe4j_password =  $config['neo4j']['password'];
        $auth = Authenticate::basic($user_neo4j, $noe4j_password);
        $driver = Driver::create($uri, authenticate: $auth);
        $session = $driver->createSession();

        $query = 'MATCH (a:Attraction {id: $id1}) DETACH DELETE a;';
        $param = ['id1' => new MongoDB\BSON\ObjectId($delete)];
        $session->run($query, $param);
    }

}

?>