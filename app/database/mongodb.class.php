<?php

class mongoDB{
    private static $manager = null;
    private static $client = null;
    private static $database = null;
    private function __construct(){}
    private function __clone(){}
    public static function getClient(){
        if(mongoDB::$client === null){
            try{
                mongoDB::$client = new MongoDB\Client("mongodb://localhost:27017");
            }
            catch (PDOException $e){
                exit('PDO Error : ' . $e->getMessage());
            }
        }
        return mongoDB::$client;
    }

    public static function getDatabase(){
        if(mongoDB::$database === null && mongoDB::$client !== null){
            try{
                mongoDB::$database = mongoDB::$client->selectDatabase("projekt");
            }
            catch (PDOException $e){
                exit('PDO Error : ' . $e->getMessage());
            }
        }
        return mongoDB::$database;
    }

    public static function getManager(){
        if(mongoDB::$manager === null && mongoDB::$client !== null){
            try{
                mongoDB::$manager = mongoDB::$client->getManager();
            }
            catch (PDOException $e){
                exit('PDO Error : ' . $e->getMessage());
            }
        }
        return mongoDB::$manager;
    }
}
?>