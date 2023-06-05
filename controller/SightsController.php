<?php

require_once 'model/sight.class.php';
require_once 'model/sightService.class.php';

class sightsController extends BaseController {
    public function index(){
        /*if(!isset($_SESSION["user"])){
            $this->registry->template->title = "Login";
            $this->registry->template->error = false;
            $this->registry->template->show("login");
        }
        else{*/
            $this->registry->template->title = "Sights";
            $this->registry->template->error = false;

            $ss = new SightService();
            $data = $ss->getAllSights();
            $this->registry->template->data = $data;
            $this->registry->template->show_attractions = $data;
            $this->registry->template->show("sights");
        /*}*/
    }

    public function processSelectForm() {
        $selectedList = array();
        if (isset($_POST['lang'])) {           
            foreach ($_POST['lang'] as $selected) {
                $selectedList[] = $selected;
            }
            
        }
        if(isset($_POST['firstAttraction'])){
            error_log("odabran je " . $_POST['firstAttraction']);
        }
        $this->processSelect($selectedList);
    }

    public function processSelect($selectedList) {
        $this->registry->template->title = "Sights";
        $this->registry->template->error = false;

        $ss = new SightService();

        $data = $ss->getAllSights();
        $this->registry->template->data = $data;

        
        $show = $ss->getShortestPath($selectedList);
        $this->registry->template->show_attractions = $show;
        
        $this->registry->template->show("sights");
            
    }

}


?>