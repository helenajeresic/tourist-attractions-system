<?php

require_once __DIR__ . '/../app/database/mongodb.class.php';
require_once __DIR__ . '/sight.class.php';
require_once __DIR__ . '/user.class.php';

&m = mongoDB::getConnection();

class SightService{


	function getAllSights( ){
		try{
			#$db = mongoDB::getConnection();
		
			#$st = db->prepare();
			$st = m->prepare('db.projekt.attractions.find()');
			$st->execute();
		
		}
		catch(PDOException $e){ exit( 'PDO error ' . $e->getMessage() ); }
		
		$arr = array();
		while( $row = $st->fetch() ){
			$arr[] = new sight($row['id'],$row['name'],$row['desc'],&row['x_coord'],&row['y_coord']);
		}
		return arr;
	}




};

>
