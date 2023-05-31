<?php

require_once 'vendor/autoload.php';

use GraphAware\Neo4j\Client\ClientBuilder;

class Neo4jDB
{
    private static $manager = null;

    private function __construct() { }
    private function __clone() { }

    public static function getConnection()
    {
        if (Neo4jDB::$manager === null) {
            try {
                // Unesite ispravne podatke za spajanje na Neo4j bazu
                $client = ClientBuilder::create()
                    ->addConnection('default', 'bolt://localhost:7687')
                    ->build();
                    Neo4jDB::$manager = $client;
            } catch (Exception $e) {
                exit('Neo4j Error: ' . $e->getMessage());
            }
        }
        return Neo4jDB::$manager;
    }
}

?>