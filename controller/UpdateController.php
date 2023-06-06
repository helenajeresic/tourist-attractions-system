<?php 

require_once __SITE_PATH . 'model/sight.class.php';
require_once __SITE_PATH . 'model/sightService.class.php';

class UpdateController extends BaseController {
    public function index(){
        $this->registry->template->title = "Update";
        $this->registry->template->error = false;

        $ss = new SightService();
        $data = $ss->getAllSights();
        $this->registry->template->data = $data;

        $this->registry->template->show("update");
    }

    public function processUpdate() {
        $as = new AdminService();

        if(isset($_POST['lang'])) {
            $selected = $_POST['lang'];

            if(isset($_POST['naziv']) && !empty($_POST['naziv'])) 
                $as->updateName($selected,$_POST['naziv']);

            if(isset($_POST['opis']) && !empty($_POST['naziv'])) 
                $as->updateDescription($selected, $_POST['opis']);

            if(isset($_POST['x-koordinata'])) 
                $as->updateXCoordinate($selected, (int) $_POST['x-koordinata']);
            
            if(isset($_POST['y-koordinata'])) 
                $as->updateYCoordinate($selected, (int) $_POST['y-koordinata']);

            if(isset($_FILES['slika'])) 
                $as->updateImage($selected, $_FILES['slika']);
        }  
    }

 
}

?>