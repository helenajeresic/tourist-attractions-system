<?php

require_once __SITE_PATH . '/app/database/mongodb.class.php';

use MongoDB\Driver\Query;
use Laudis\Neo4j\Types\Path;

class UserService {

    public function __construct(){}

    function isUserRegistered($username, $password){
        try{
            $client = mongoDB::getClient();
            $database = mongoDB::getDatabase();

            $collection = $database->users;
            $document = $collection->findOne(['username' => $username]);
            
            if($document) {
                // Compare hashed passwords
                return password_verify($password, $document->passwordHash);
            } else {
                return false;
            }
        }
        catch(PDOException $e){ exit( 'PDO error ' . $e->getMessage() ); }
    }

    function doesUserExist($email){
        try{
            $client = mongoDB::getClient();
            $database = mongoDB::getDatabase();

            $collection = $database->users;
            $document = $collection->findOne(['email' => $email]);
            
            return $document != null;
        }
        catch(PDOException $e){ exit( 'PDO error ' . $e->getMessage() ); }
    }

    function registerNewUser($name, $email, $username, $password){
        try{
            $client = mongoDB::getClient();
            $database = mongoDB::getDatabase();

            $collection = $database->users;

            // Hash the password for security
            $passwordHash = password_hash($password, PASSWORD_BCRYPT);
            $newUser = [
                'name' => $name,
                'email' => $email,
                'username' => $username,
                'passwordHash' => $passwordHash,
            ];

            $insertOneResult = $collection->insertOne($newUser);
            return $insertOneResult->getInsertedCount() > 0;
        }
        catch(PDOException $e){ exit( 'PDO error ' . $e->getMessage() ); }
    }
};
?>
