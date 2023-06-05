<?php

require_once __SITE_PATH . '/app/database/mongodb.class.php';

require_once __SITE_PATH . '/model/sight.class.php';
require_once __SITE_PATH . '/model/user.class.php';

use MongoDB\Driver\Query;

class SightService {

	public function __construct(){}

	function getAllSights(){
		
		try{
			$client = mongoDB::getClient();
			$database = mongoDB::getDatabase();

			$collection = $database->attractions;
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
			$MongoDatabase = mongoDB::getDatabase();
			$collection = $MongoDatabase->attractions;

			$neoDatabase = Neo4jDB::getConnection();

			$params = [
				'attractionIds' => $attractionList,
				'firstSelected' => (int)$firstSelected
			];

			// $query = 'MATCH (start:Attraction), (end:Attraction)
            //       WHERE start.id = $firstSelected AND end.id IN $attractionIds
            //       CALL algo.shortestPath.stream(start, end, "DISTANCE", {weightProperty: "dist"})
            //       YIELD nodeId, cost
            //       RETURN algo.getNodeById(nodeId).id AS attractionId, cost
            //       ORDER BY cost';
			$query = 'MATCH (start:Attraction {id: $firstSelected}), (end:Attraction)
			WHERE end.id IN $attractionIds
			CALL apoc.path.spanningTree(start, {
			  labelFilter: ">Attraction",
			  relationshipFilter: ">CONNECTED_TO",
			  endNodes: $attractionIds,
			  limit: toInteger(size($attractionIds)) - 1,
			  weightProperty: "dist"
			}) YIELD path
			RETURN collect(path) AS paths';
        	$result = $neoDatabase->run($query, $params);
			$idList = array();

			foreach ($result->getResults() as $record) {
				// $attractionId = $record->get('attractionId');
				// $cost = $record->get('cost');
	
				// $idList[] = $attractionId ;
				$paths = $record->get('paths');
    
				foreach ($paths as $path) {
					foreach ($path->nodes() as $node) {
						$attractionId = $node->value('id');
						$idList[] = $attractionId;
					}
				}
			}

			$arr = array();

			foreach($attractionList as $attractionId) {
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