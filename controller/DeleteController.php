<?php 

require_once __SITE_PATH .  '/model/sightService.class.php';
require_once __SITE_PATH .  '/model/adminService.class.php';
require_once __SITE_PATH .  '/controller/SightsController.php';

class deleteController extends BaseController {
    public function index(){
        $this->registry->template->title = "Delete";
        $this->registry->template->error = false;

        $ss = new SightService();
        $data = $ss->getAllSights();
        $this->registry->template->data = $data;

        $this->registry->template->show("delete");
    }

    public function processDelete(){
        if(isset($_POST['lang'])) {
            $selected = $_POST['lang'];

            $as = new AdminService();
            $as->deleteMongoDB($selected);
            $as->deleteNeo4j($selected);
        }

        header('Location: ' . __SITE_URL . 'index.php?rt=sights');
    }
}

?>