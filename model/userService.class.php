<?php

require_once __SITE_PATH . '/app/database/mongodb.class.php';

use MongoDB\Driver\Query;
use Laudis\Neo4j\Types\Path;

class UserService {

    public function __construct() {}

    function isUserRegistered($username, $password) {
        try {
            $client = mongoDB::getClient();
            $database = mongoDB::getDatabase();

            $collection = $database->users;
            $document = $collection->findOne(['username' => ['$eq' => $username]]);
            
            if($document) {
                // Compare hashed passwords
                return password_verify($password, $document->passwordHash);
            } else {
                return false;
            }
        } catch(PDOException $e) { 
            exit( 'PDO error ' . $e->getMessage() ); 
        }
    }

    function doesUserExist($email) {
        try {
            $client = mongoDB::getClient();
            $database = mongoDB::getDatabase();

            $collection = $database->users;
            $document = $collection->findOne(['email' => ['$eq' => $email]]);
            
            return $document != null;
        } catch(PDOException $e) {
            exit( 'PDO error ' . $e->getMessage() ); 
        }
    }

    function registerNewUser($name, $lastname, $email, $username, $password) {
        try {
            $client = mongoDB::getClient();
            $database = mongoDB::getDatabase();
    
            $collection = $database->users;
    
            $passwordHash = password_hash($password, PASSWORD_BCRYPT);
    
            $newUser = [
                "_id" => new MongoDB\BSON\ObjectId,
                "username" => $username,
                "passwordHash" => $passwordHash,
                "email" => $email,
                "registrationSequence" => $this->generateRandomString(10),
                "hasRegistered" => 1,
                "isAdmin" => 0,
                "name" => $name,
                "lastname" => $lastname
            ];
    
            $insertOneResult = $collection->insertOne($newUser);
            return $insertOneResult->getInsertedCount() > 0;
        } catch(PDOException $e) { 
            exit( 'PDO error ' . $e->getMessage() ); 
        }
    }
    

    function isAdmin($username) {
        try {
            $client = mongoDB::getClient();
            $database = mongoDB::getDatabase();
    
            $collection = $database->users;
            $document = $collection->findOne(['username' => $username]);
            
            if($document) {
                // return isAdmin value from the document
                return isset($document->isAdmin) ? $document->isAdmin : false;
            } else {
                return false;
            }
        } catch(PDOException $e) { 
            exit( 'PDO error ' . $e->getMessage() ); 
        }
    }

    public function doesUsernameExist($username) {
        try {
            $client = mongoDB::getClient();
            $database = mongoDB::getDatabase();

            $collection = $database->users;
            $document = $collection->findOne(['username' => ['$eq' => $username]]);

            return $document != null;
        } catch (PDOException $e) {
            exit('PDO error ' . $e->getMessage());
        }
    }

    function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
            for($i = 0; $i < $length; $i++) {
                $randomString .= $characters[rand(0, $charactersLength - 1)];
            }
        return $randomString;
    }
};
?>
