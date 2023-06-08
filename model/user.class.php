<?php

class User {
    private $id;
    private $username;
    private $passwordHash;
    private $email;
    private $registrationSequence;
    private $hasRegistered;
    private $isAdmin;
    private $name;
    private $lastname;

    public function __construct() {}

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getUsername() {
        return $this->username;
    }

    public function setUsername($username) {
        $this->username = $username;
    }

    public function getpasswordHash() {
        return $this->passwordHash;
    }

    public function setpasswordHash($passwordHash) {
        $this->passwordHash = $passwordHash;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function getregistrationSequence() {
        return $this->registrationSequence;
    }

    public function setregistrationSequence($registrationSequence) {
        $this->registrationSequence = $registrationSequence;
    }

    public function gethasRegistered() {
        return $this->hasRegistered;
    }

    public function sethasRegistered($hasRegistered) {
        $this->hasRegistered = $hasRegistered;
    }

    public function getisAdmin() {
        return $this->isAdmin;
    }

    public function setisAdmin($isAdmin): void {
        $this->isAdmin = $isAdmin;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function getLastname() {
        return $this->lastname;
    }

    public function setLastname($lastname) {
        $this->lastname = $lastname;
    }

    public function getFieldsForSave() {
        return array(
            '_id' => $this->id,
            'username' => $this->username,
            'passwordHash' => $this->passwordHash,
            'email' => $this->email,
            'registrationSequence' => $this->registrationSequence,
            'hasRegistered' => $this->hasRegistered,
            'isAdmin' => $this->isAdmin,
            'name' => $this->name,
            'lastname' => $this->lastname
        );
    }

    public function getFieldsForUpdate() {
        return array(
            'username' => $this->username,
            'passwordHash' => $this->passwordHash,
            'email' => $this->email,
            'registrationSequence' => $this->registrationSequence,
            'hasRegistered' => $this->hasRegistered,
            'isAdmin' => $this->isAdmin,
            'name' => $this->name,
            'lastname' => $this->lastname
        );
    }
}