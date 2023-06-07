<?php

require "vendor/autoload.php";
require_once __SITE_PATH .  '/model/UserService.class.php';


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
        $name = $_POST['first_name'];
        $lastname = $_POST['last_name'];
        $email = $_POST['email'];
        $username = $_POST['username'];
        $password = $_POST['password'];

        $userService = new UserService();

        if($userService->doesUserExist($email)){
            echo "Account with this email already exists";
        } else {
            if($userService->registerNewUser($name, $lastname, $email, $username, $password)){
                echo "Account successfully created. Welcome email has been sent to your registered email.";
                // Send welcome email
                if(isset($_POST['submit'])){
                    if (isset($_POST['name'])) {
                        $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
                    }
                    if (isset($_POST['mail'])) {
                        $email = filter_var($_POST['email'], FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
                    }
                    
                    $companiEmail ="";
                    $companiName ="Moj Turizam";
                    $subject = "Uspješna registracija Turizam";
                    $message = "Dragi/draga ".$name." drago nam je što ste se sa svojim mailom: ".$email."  prijavili na našu turisticku aplikaciju";
                    
                    $mail = new PHPMailer(true);
    
                    $mail->isSMTP();
                    $mail->SMTPAuth = true;
    
                    $mail->Host = "smtp.gmail.com";
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                    $mail->Port = 587;
                    $mail->Username = "";
                    $mail -> Password ="";
                    $mail->CharSet = "UTF-8";
    
                    $mail->setFrom($companiEmail, $companiName);
                    $mail->addAddress($email);
    
                    $mail->Subject = $subject;
                    $mail->Body = $message;
    
                    $mail->send();
                    header('Location: ' . __SITE_URL . 'index.php?rt=sights/index');
                    
                }
                
            } else {
                echo "There was a problem creating your account.";
            }
        }
    }

       

    function processLogin()
    {

        $username = $_POST['username'];
        $password = $_POST['password'];
        
        $userService = new UserService();
        
        if ($userService->isUserRegistered($username, $password)) {
            header('Location: ' . __SITE_URL . 'index.php?rt=sights/index');
            exit();
        } else {
            // echo "Incorrect username or password";
            $_SESSION['error'] = "Incorrect username or password, try again";
            header('Location: ' . __SITE_URL . 'index.php?rt=login');
        }

        // if(!$this->isRegistered($username, $password)){
        //     $this->registry->template->error = 'Incorrect username or password.';
        //     $this->registry->template->show("login");
        // } else {
        //     // if(isAdmin($username)){
        //     //     $_SESSION["admin"] = true;
        //     // }
        //     $_SESSION["user"] = $username;
        //     header('Location: ' . __SITE_URL . 'index.php?rt=sights/index');
        // }

        // trivijalna logika, samo za probu
        // if($username === 'Matej' && $password ==='12345'){
        //     $_SESSION["user"] = $username;
        //     header('Location: ' . __SITE_URL . 'index.php?rt=sights/index');
    }

    function register() {
        $this->registry->template->title = "Register";
        $this->registry->template->error = false;
        $this->registry->template->show("register");
    }
}

?>