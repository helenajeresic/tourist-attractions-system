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
        if(isset($_POST['lan'])){
            $firstSelected = $_POST['lan'];
        }
        $this->processSelect($selectedList,$firstSelected );
    }

    public function processSelect($selectedList, $firstSelected) {
        $this->registry->template->title = "Sights";
        $this->registry->template->error = false;

        $ss = new SightService();

        $data = $ss->getAllSights();
        $this->registry->template->data = $data;

        
        $show = $ss->getShortestPath($selectedList, $firstSelected);
        if($show === null){
            $this->registry->template->error = true;
            echo "nisu dobro obradene znamenitorsi";
        }
        else {
            $this->registry->template->show_attractions = $show;
        }
        
        $this->registry->template->show("sights");
            
    }

}


?>