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
			if($attractionList !== [$firstSelected]){
				//micemo firstSelected iz ukupne liste
				$attractionList = array_diff($attractionList, [$firstSelected]);

				$neoDatabase = $this->getNeoSession();
				$idList = array();

				$sizeOfAttractionList = count($attractionList);

				
				$idList[] = $firstSelected;

				for( $i = 0; $i < $sizeOfAttractionList; ++$i){
					$params = [
						'attractionIds' => array_values($attractionList),
						'firstSelected' => $firstSelected,
					];
					$results = $neoDatabase->run('
					MATCH (startNode:Attraction {id: $firstSelected})-[dist:DISTANCE]-(next:Attraction)
					WHERE next.id IN $attractionIds AND next <> startNode
					RETURN next.id, dist.attribute AS distance
					ORDER BY distance ASC
					LIMIT 1;' , $params);
					
					if($results->isEmpty()) {
						error_log("prazno");
						sleep(2);
					}
					else{
						error_log("dobro je");
						$firstSelected = $results->first()['next.id'];
						$attractionList = array_diff($attractionList, [(string)$firstSelected]);
						$idList[] = $firstSelected;
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