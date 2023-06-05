<?php

require_once __SITE_PATH . '/app/database/mongodb.class.php';
require_once __SITE_PATH . '/model/user.class.php';
require_once __SITE_PATH . '/model/sight.class.php';


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


};

?>