<?php

class loginController extends BaseController{
    public function index(){
        if(!isset($_SESSION["user"])){
            $this->registry->template->title = "Login";
            $this->registry->template->error = false;
            $this->registry->template->show("login");
        }
    }

    function processLoginForm()
    {
        if (isset($_POST["register"])) $this->processRegister();
        if (isset($_POST["login"])) $this->processLogin();
    }

    function processRegister()
    {
        
    }

    function processLogin()
    {
        $username = $_POST["username"];
        $password = $_POST["password"];

        if($this->isRegisterd($username, $password)){
            // if(isAdmin($username)){
            //     $_SESSION["admin"] = true;
            // }
            $_SESSION["user"] = $username;
            header('Location: ' . __SITE_URL . 'index.php?rt=sights/index');
        }

        // trivijalna logika, samo za probu
        // if($username === 'Matej' && $password ==='12345'){
        //     $_SESSION["user"] = $username;
        //     header('Location: ' . __SITE_URL . 'index.php?rt=sights/index');
    }

    function isRegisterd($username, $password){
        return true;
    }

    // function isAdmin
}

?>