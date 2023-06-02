<?php

class mongoDB{
    private static $manager = null;
    private function __construct(){}
    private function __clone(){}
    public static function getConnection(){
        if(mongoDB::$manager === null){
            try{
                $mongoClient = new MongoDB\Client("mongodb://localhost");
                $database = $mongoClient->selectDatabase("DATABASE_NAME");
                mongoDB::$manager = $database;
            }
            catch (PDOException $e){
                exit('PDO Error : ' . $e->getMessage());
            }
        }
        return mongoDB::$manager;
    }
}
?>