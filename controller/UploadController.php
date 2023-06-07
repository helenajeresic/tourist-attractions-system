<?php 

require_once __SITE_PATH . '/model/sightService.class.php';
require_once __SITE_PATH . '/model/adminService.class.php';
require_once __SITE_PATH .  '/controller/SightsController.php';

class UploadController extends BaseController {
    public function index(){
        if(isset($_SESSION['admin'])){
            $this->registry->template->title = "Upload";
            $this->registry->template->error = false;
            $this->registry->template->show("upload");
        }
        else {
            header('Location: ' . __SITE_URL . 'index.php?rt=sights');
        }
    }

    public function processUpload(){
        $as = new AdminService();
        
        $res = $as->addUploadToDatabases();

        if($res === false){
            $_SESSION['error'] = "Pokušali ste unijeti atrakciju s imenom ili koordinatama koje već postoje. \n
            Unesite drugu atrakciju ili pređite na drugu radnju.";
            header('Location: ' . __SITE_URL . 'index.php?rt=upload');
        }
        else {
            header('Location: ' . __SITE_URL . 'index.php?rt=sights');
        }
    }
}

?>