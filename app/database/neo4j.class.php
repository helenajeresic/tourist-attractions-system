<?php

require_once 'vendor/autoload.php';

use GraphAware\Neo4j\Client\ClientBuilder;
use Laudis\Neo4j\Authentication\Authenticate;
use Laudis\Neo4j\Basic\Driver;

class Neo4jDB
{
    private static $session = null;

    private function __construct() { }
    private function __clone() { }

    public static function getConnection()
    {
        $config = require_once __SITE_PATH . '/app/config.php';
        if (Neo4jDB::$session === null) {
            try {
                $user_neo4j = $config['neo4j']['username'];
                $noe4j_password =  $config['neo4j']['password'];
                $auth = Authenticate::basic($user_neo4j, $noe4j_password);
                $uri =  sprintf("http://{$user_neo4j}:{$noe4j_password}@localhost:7474/", $noe4j_password);
                $driver = Driver::create($uri, authenticate: $auth);
                Neo4jDB::$session = $driver->createSession();
            } catch (Exception $e) {
                exit('Neo4j Error: ' . $e->getMessage());
            }
        }
        return Neo4jDB::$session;
    }
}

?>