<?php
require_once __SITE_PATH . '/app/database/mongodb.class.php';
require_once __SITE_PATH . '/app/database/documents.php';
require_once __SITE_PATH . '/vendor/autoload.php';
$config = require_once __SITE_PATH . '/app/config.php';

use Laudis\Neo4j\Authentication\Authenticate;
use Laudis\Neo4j\Basic\Driver;
$bulk_users = new MongoDB\Driver\BulkWrite;
$bulk_attractions = new MongoDB\Driver\BulkWrite;

$username_mongo = $config['mongoDB']['username'];
$password_mongo = $config['mongoDB']['password'];
$encodedPassword_mongo = urlencode($password_mongo);

$database_mongo =$config['mongoDB']['database'];

$user_neo4j = $config['neo4j']['username'];
$noe4j_password = $config['neo4j']['password'];
$uri = sprintf("http://{$user_neo4j}:{$noe4j_password}@localhost:7474/", $noe4j_password);

$auth = Authenticate::basic($user_neo4j, $noe4j_password);
$driver = Driver::create($uri, authenticate: $auth);
$session = $driver->createSession();

$mongo_Client = mongoDB::getCLient();
$mongo_Database = mongoDB::getDatabase();
$mongo_manager = mongoDB::getManager();

// dropamo obje baze
$mongo_Database->drop();
$res = $session->run('MATCH (n) DETACH DELETE n');
$userList = Array();

foreach($documents_users as $document) {
    $bulk_users->insert($document);
    array_push($userList, $document['username']);
}

$attractionList = Array();

foreach($documents_attractions as $document) {
    $bulk_attractions->insert($document);
    $query = 'CREATE (a:Attraction) SET a.id = $attraction_id, a.x_coordinate = $x_coordinate, a.y_coordinate = $y_coordinate ';
    $params = ['attraction_id' => $document['_id'], 'x_coordinate'=> $document['x_coordinate'] , 'y_coordinate'=> $document['y_coordinate']];
    $session->run($query, $params);
    array_push($attractionList, array($document['_id'], $document['x_coordinate'], $document['y_coordinate'] ));
}

function euclideanDistance($x1, $y1, $x2, $y2) {
    $distance = sqrt(pow($x2 - $x1, 2) + pow($y2 - $y1, 2));
    return $distance;
}

for($i = 0; $i < count($attractionList); ++$i) {
    for($j = $i + 1; $j < count($attractionList); ++$j) {
        $calcDist = euclideanDistance($attractionList[$i][1], $attractionList[$i][2], $attractionList[$j][1], $attractionList[$j][2]);

        $query1 = 'MATCH (a1:Attraction {id: $id1}), (a2:Attraction {id: $id2}) CREATE (a1)-[d:DISTANCE]->(a2) SET d.attribute = $dist';
        $params1 = ['id1' => $attractionList[$i][0], 'id2' => $attractionList[$j][0], 'dist' => (int)$calcDist];
        $result1 = $session->run($query1, $params1);
    }
}

$mongo_manager->executeBulkWrite($database_mongo. '.users', $bulk_users);
$mongo_manager->executeBulkWrite($database_mongo. '.attractions', $bulk_attractions);

error_log( "mongoDB i neo4j baza kreirane.");
?>