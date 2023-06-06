<?php 

require_once 'model/sightService.class.php';
require_once 'model/adminService.class.php';

class UploadController extends BaseController {
    public function index(){
        $this->registry->template->title = "Upload";
        $this->registry->template->error = false;
        $this->registry->template->show("upload");
    }

    public function processUpload(){
        $as = new AdminService();
        $as->processImageUpload();
        $as->addUploadToDatabases();
    }
}

?>