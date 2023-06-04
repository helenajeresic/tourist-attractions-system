<?php
require_once __DIR__ . '/mongodb.class.php';
require_once __DIR__ . '/documents.php';
require_once '../../vendor/autoload.php';

use GraphAware\Neo4j\Client\ClientBuilder;

$client = ClientBuilder::create()
    ->addConnection('default', 'http://neo4j:lozinka@localhost:7474') //upiši password za neo4j
    ->build();

$m = mongoDB::getConnection();

$bulk = new MongoDB\Driver\BulkWrite;

$userList = Array();

foreach ($documents_user as $document){
    $bulk->insert($document);
    array_push($userList, $document['username']);
}


$attractionList = Array();

foreach ($documents_attractions as $document){
    $bulk->insert($document);
    // popravi da create odgovara za nasu bazu 
    $result = $client->run('CREATE (a:Attraction) SET a.id = $_id',['_id' => $document['_id']]);
    array_push($attractionList, array($document['_id'], $document['x_coordinate'], $document['y_coordinate'] ));
}

function euclideanDistance($x1, $y1, $x2, $y2){
    $distance = sqrt(pow($x2 - $x1, 2) + pow($y2 - $y1, 2));
    return $distance;
}

//popravi da bude za sve atrakcije
for( $i = 0; $i < count($attractionList); ++$i){
    for( $j = $i + 1; $i < count($attractionList); ++$j){
        $calcDist = euclideanDistance($attractionList[$i][1], $attractionList[$i][2], $attractionList[$j][1], $attractionList[$j][2]);
        $result = $client->run('MATCH (a1:Attraction {id : $id1}), (a2:Attraction {id : $id2}) CREATE (a1)-[d:DISTANCE]->(a2) SET d.attribute = $dist;', ['id1' => $attractionList[$i][0], 'id2' => $attractionList[$j][0], 'dist' => $calcDist]);
        $result = $client->run('MATCH (a1:Attraction {id : $id1}), (a2:Attraction {id : $id2}) CREATE (a1)<-[d:DISTANCE]-(a2) SET d.attribute = $dist;', ['id1' => $attractionList[$i][0], 'id2' => $attractionList[$j][0], 'dist' => $calcDist]);
    }
}

$m->executeBulkWrite('projekt.users', $bulk);
$m->executeBulkWrite('projekt.attractions', $bulk);

echo "mongoDB i neo4j baza kreirane.";
?>