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
        echo "<script> console.log('" . $_POST['register'] . "'); </script>";
    }

    function processLogin()
    {
        echo "<script> console.log('" . $_POST['login'] . "'); </script>";
    }
}

?>