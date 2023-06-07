<?php 

require_once __SITE_PATH . '/model/sightService.class.php';
require_once __SITE_PATH . '/model/adminService.class.php';
require_once __SITE_PATH .  '/controller/SightsController.php';

class UploadController extends BaseController {
    public function index(){
        $this->registry->template->title = "Upload";
        $this->registry->template->error = false;
        $this->registry->template->show("upload");
    }

    public function processUpload(){
        $as = new AdminService();
        // $as->processImageUpload();
        $as->addUploadToDatabases();

        header('Location: ' . __SITE_URL . 'index.php?rt=sights');
    }
}

?>