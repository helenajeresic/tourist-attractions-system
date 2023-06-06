<?php

require_once __SITE_PATH . '/app/database/mongodb.class.php';
require_once __SITE_PATH . '/app/database/neo4j.class.php';

require_once __SITE_PATH . '/model/sight.class.php';
require_once __SITE_PATH . '/model/user.class.php';

use MongoDB\Driver\Query;
use Laudis\Neo4j\Types\Path;

class SightService {

	private $mongoAttraction = null;
    private $neo4jSession = null;
	public function __construct(){}

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

	function getAllSights(){
		
		try{
			$collection = $this->getMongoAttractions();
			$documents = $collection->find();
		}
		catch(PDOException $e){ exit( 'PDO error ' . $e->getMessage() ); }
		
		$arr = array();

		foreach($documents as $document){
			$arr[] = new sight($document["_id"], $document["name"], $document["description"], $document["image_path"], $document["x_coordinate"], $document["y_coordinate"]);
		}
		return $arr;
	}

	function getShortestPath($attractionList, $firstSelected) {
		try {

			$sizeOfAttractionList = count($attractionList);
			$idList = array();
			if($attractionList !== [$firstSelected]){
			//micemo firstSelected iz ukupne liste
			$attractionList = array_diff($attractionList, [$firstSelected]);
			$neoDatabase = $this->getNeoSession();

			$params = [
				'attractionIds' => array_values($attractionList),
				'firstSelected' => $firstSelected,
				'sizeOfAttractionList' => (int)$sizeOfAttractionList -1
			];

			
			$idList[] = $firstSelected;

			// $results = $neoDatabase->run('MATCH (p:Attraction {id: $firstSelected})
			// MATCH (whitelist:Attraction)
			// WHERE whitelist.id IN $attractionIds
			// WITH p, collect(whitelist) AS whitelistNodes
			// CALL apoc.path.spanningTree(p, {
			// 	relationshipFilter: "DISTANCE>",
			// 	whitelistNodes: whitelistNodes,
			// 	uniqueness: "NODE_GLOBAL"
			// })
			// YIELD path
			// RETURN path;' , $params);
			$results = $neoDatabase->run('MATCH (startNode:Attraction {id: $firstSelected})
			WITH startNode
			
			MATCH (attraction:Attraction)
			WHERE attraction.id IN $attractionIds AND attraction <> startNode
			WITH startNode, collect(attraction) AS attractions

			WITH startNode, attractions, apoc.coll.randomItem(attractions) AS endNode

				CALL apoc.algo.dijkstra(
				startNode,
				endNode,
			  "|DISTANCE",
			  "attribute",
			  NaN,
			  size(attractions) + 1
			) YIELD path, weight
			WHERE ALL(n IN attractions WHERE n IN nodes(path))
			AND size(nodes(path)) = size(attractions) + 1
							
			RETURN nodes(path) AS nodes, relationships(path) AS relationships;' , $params);
			// WHERE length(path) = $sizeOfAttractionList
			if($results->isEmpty()) {
				error_log("prazno");
				sleep(2);
			}
			else {
				// LIMITALI smo na 1 tako da ce se ovo vjv samo 1 vrtiti
				foreach ($results as $result) {
					$paths = $result->values();

					foreach($paths as $path){
						foreach($path as $node){
							error_log("nod je" . $node->get('id'));
						}
					}
					
				}
			}
		}
		else{
			$idList = array();
		}
			$collection = $this->getMongoAttractions();
			$arr = array();

			foreach($idList as $attractionId) {
				try {
					$filter = ["_id" => new MongoDB\BSON\ObjectId($attractionId)];	
					$document = $collection->findOne($filter);
					$arr[] = new sight(
							$document["_id"],
							$document["name"],
							$document["description"],
							$document["image_path"],
							$document["x_coordinate"],
							$document["y_coordinate"]	
						);
					
				} catch (Exception $e) {
					exit();
				}
			}
			
			return $arr;
		} catch (Exception $e) {
			exit('Error: ' . $e->getMessage());
		}
}

};

?>