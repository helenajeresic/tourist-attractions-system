<?php

require "vendor/autoload.php";
require_once __SITE_PATH .  '/model/userService.class.php';
$config = require __SITE_PATH . '/app/config.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class loginController extends BaseController{
    public function index(){
        if(!isset($_SESSION["user"])){
            $this->registry->template->title = "Login";
            $this->registry->template->error = false;
            $this->registry->template->show("login");
        }
        else {
            header('Location: ' . __SITE_URL . 'index.php?rt=sights/index');
        }
    }

    function processLoginForm() {
        if (isset($_POST["register"])) {
            $this->processRegister();
        } else if (isset($_POST["login"])) {
            $this->processLogin();
        }
    }
    
    function processRegister()
    {
        $name = isset($_POST['first_name']) ? $this->validateStringInput($_POST['first_name']) : false;
        $lastname = isset($_POST['first_name']) ? $this->validateStringInput($_POST['first_name']) : false;
        $email = isset($_POST['email']) ? $this->validateEmail($_POST['email']) : false;
        $username = isset($_POST['username']) ? $this->validateStringInput($_POST['username']) : false;
        $password = isset($_POST['password']) ? $this->validatePassword($_POST['password']) : false;

        // if any of the fields or the email is not valid, abort the request and reroute user to login
        if (!$name || !$lastname || !$email || !$username || !$password) {
            header('Location: ' . __SITE_URL . 'index.php?rt=login/register');
            exit();
        }

        $userService = new UserService();

        if($userService->doesUserExist($email)){
            $_SESSION['registrationFail'] =  "<p class='error'>Korisnički račun s navedenom mail adresom postoji, pokušajte ponovno</p>";
            header('Location: ' . __SITE_URL . 'index.php?rt=login/register');
        } else if( $userService->doesUsernameExist($username)){
            $_SESSION['registrationFail'] = "<p class='error'>Korisničko ime već postoji, pokušajte s drugim korisničkim imenom</p>";
            header('Location: ' . __SITE_URL . 'index.php?rt=login/register');
        } else {
            if($userService->registerNewUser($name, $lastname, $email, $username, $password)){
                $_SESSION['registrationSuccess'] =  "<p class='success'>Korisnički račun uspješno stvoren. Potvrdi mail je poslan na Vašu mail adresu</p>";
                // Send welcome email
                if(isset($_POST['submit'])){
                    
                    try {
                    $config = require __SITE_PATH . '/app/config.php';
                    $companyEmail = $config['company']['Username'];
                    $companyName = "Moj Turizam";
                    $subject = "Uspješna registracija Turizam";
                    $message = "Dragi/draga ".$name." drago nam je što ste se sa svojim mailom: ".$email."  prijavili na našu turisticku aplikaciju";
                    
                    $mail = new PHPMailer(true);
    
                    $mail->isSMTP();
                    $mail->SMTPAuth = true;
    
                    $mail->Host = "smtp.gmail.com";
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                    $mail->Port = 587;
                    $mail->Username = $config['company']['Username'];
                    $mail -> Password = $config['company']['Password'];
                    $mail->CharSet = "UTF-8";
    
                    $mail->setFrom($companyEmail, $companyName);
                    $mail->addAddress($email);
    
                    $mail->Subject = $subject;
                    $mail->Body = $message;
    
                    $mail->send();
                    header('Location: ' . __SITE_URL . 'index.php?rt=sights/index');
                    }
                    catch (Exception $e) {
                        error_log('Email wasnt send successfully ' . $e->getMessage());
                        $_SESSION['registrationError'] =  "<p class='error'>Neuspjeli pokušaj registracije, pokušajte ponovno</p>";
                        header('Location: ' . __SITE_URL . 'index.php?rt=sights/index');
                    }
                    
                }
                
            } else {
                $_SESSION['registrationError'] =  "<p class='error'>Neuspjeli pokušaj registracije, pokušajte ponovno</p>";
                header('Location: ' . __SITE_URL . 'index.php?rt=login/register');
            }
        }
    }

       

    function processLogin()
    {

        $username = $_POST['username'];
        $password = $_POST['password'];
        
        $userService = new UserService();
        
        if ($userService->isUserRegistered($username, $password)) {
            $_SESSION['user'] = true;
            if($this->isAdmin($username))
                $_SESSION['admin'] = true;
            header('Location: ' . __SITE_URL . 'index.php?rt=sights/index');
            exit();
        } else {
            $_SESSION['loginError'] =  "<p class='error'>Netočan unos lozinke ili mail-a, pokušajte ponovno</p>";
            header('Location: ' . __SITE_URL . 'index.php?rt=login');
        }
    }

    function register() {
        $this->registry->template->title = "Register";
        $this->registry->template->error = false;
        $this->registry->template->show("register");
    }

    function isAdmin($username){
        $userService = new UserService();
        return $userService->isAdmin($username);
    }

    function out() {
        session_unset();
        session_destroy();

        header('Location: ' . __SITE_URL . 'index.php?rt=login');
    }
    function sanitizeInput($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    function validateStringInput($name) {
        $name = $this->sanitizeInput($name);
        if (!preg_match("/^[a-zA-Z-' ]*$/", $name)) {
            $_SESSION['registrationError'] =  "<p class='error'>Nedozvoljeni unos znakova</p>";
            return false;
        }
        return $name;
    }

    function validatePassword($password) {
        $password = $this->sanitizeInput($password);
        if (strlen($password) < 8) {
            $_SESSION['registrationError'] =  "<p class='error'>Lozinka treba sadržavati najmanje 8 znakova</p>";
            return false;
        }
        return $password;
    }

    function validateEmail($email) {
        $email = $this->sanitizeInput($email);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['registrationError'] =  "<p class='error'>Korisnička adresa je neispravnog oblka</p>";
            return false;
        }
        return $email;
    }   
}

?>