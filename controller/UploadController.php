<?php 

class UploadController extends BaseController {
    public function index(){
        $this->registry->template->title = "Upload";
        $this->registry->template->error = false;
        $this->registry->template->show("upload");
    }

}

?>