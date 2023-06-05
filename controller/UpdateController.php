<?php 

require_once 'model/sight.class.php';
require_once 'model/sightService.class.php';

class UpdateController extends BaseController {
    public function index(){
        $this->registry->template->title = "Update";
        $this->registry->template->error = false;

        $ss = new SightService();
        $data = $ss->getAllSights();
        $this->registry->template->data = $data;

        $this->registry->template->show("update");
    }

    public function processUpdate(){
       // $this->updateMongoDB();
       // $this->updateNeo4j();
    }

    function updateMongoDB(){
        require_once __SITE_PATH . '/app/database/mongodb.class.php';

    }

    function updateNeo4j(){

    }

}

?>