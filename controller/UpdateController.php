<?php 

require_once __SITE_PATH . '/model/sight.class.php';
require_once __SITE_PATH . '/model/sightService.class.php';
require_once __SITE_PATH . '/model/adminService.class.php';
require_once __SITE_PATH .  '/controller/SightsController.php';


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

        if(isset($_POST['lang']) && !empty($_POST['lang'])) {
            $selected = $_POST['lang'];


            if(isset($_POST['naziv']) && !empty($_POST['naziv'])) {
                $as->updateName($selected,$_POST['naziv']);
            }

            if(isset($_POST['opis']) && !empty($_POST['opis'])){

                $as->updateDescription($selected, $_POST['opis']);
            }

            if(isset($_POST['x-koordinata']) && !empty($_POST['x-koordinata'])){
                if(isset($_POST['y-koordinata']) && !empty($_POST['x-koordinata'])){
                    $as->updateCoordinates($selected, (int) $_POST['y-koordinata'], (int) $_POST['y-koordinata']);
                }
                else {
                    $as->updateXCoordinate($selected, (int) $_POST['x-koordinata']);
                }
            }
            else if(isset($_POST['y-koordinata']) && !empty($_POST['y-koordinata'])) {
                $as->updateYCoordinate($selected, (int) $_POST['y-koordinata']);
            }

            if(isset($_FILES['slika']) && $_FILES['slika']['error'] === UPLOAD_ERR_OK){
                $as->updateImage($selected, $_FILES['slika']['name']);
            }
        }  

        header('Location: ' . __SITE_URL . 'index.php?rt=sights');
    }

 
}

?>