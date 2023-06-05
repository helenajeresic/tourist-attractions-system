<?php

require_once __DIR__ . '/../app/database/mongodb.class.php';
require_once __DIR__ . '/sight.class.php';
require_once __DIR__ . '/user.class.php';

use MongoDB\Driver\Query;

class SightService {

	function getAllSights(){
		
		try{
			$database = mongoDB::getDatabase();

			$collection = $database->attractions;
			$documents = $collection->find();
		
		}
		catch(PDOException $e){ exit( 'PDO error ' . $e->getMessage() ); }
		
		$arr = array();

		foreach($documents as $document)
			$arr[] = new sight($document['_id'], $document['name'], $document['description'], $document['image_path'], $document['x_coordinate'], $document['y_coordinate']);
		
		return $arr;
	}

	function getShortestPath($attractionList) {
		//za sad vrati samo one koje sam odabrala

		try {
			$client = mongoDB::getClient();
			$database = mongoDB::getDatabase();
			$collection = $database->attractions;

			$arr = array();

			foreach($attractionList as $attractionId) {
				try {
					$filter = ['_id'=> new MongoDB\BSON\ObjectId($attractionId)];	

					$document = $collection->find($filter)->toArray();
						var_dump($document);
						$arr[] = new sight(
								$document->_id,
								$document->name,
								$document->description,
								$document->image_path,
								$document->x_coordinate,
								$document->y_coordinate	
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