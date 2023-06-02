<?php

class sightsController extends BaseController{
    public function index(){
        if(!isset($_SESSION["user"])){
            $this->registry->template->title = "Login";
            $this->registry->template->error = false;
            $this->registry->template->show("login");
        }
        else{
            $this->registry->template->title = "Sights";
            $this->registry->template->error = false;
            $this->registry->template->show("sights");
        }
    }
}


?>