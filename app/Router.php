<?php

class Router {

    private $registry;
    private $path;
    private $args = array();
    public $file;
    public $controller;
    public $action;
    function __construct($registry){
        $this->registry = $registry;
    }
    function setPath($path){
        if(is_dir($path) === false){
            throw new Exception ('Invalid controller path: `' . $path . '`');
        }
        $this->path = $path;
    }
    public function loader(){
        $this->getController();
        if(is_readable($this->file) === false){
            $this->file = $this->path . '/_404Controller.php';
            $this->controller = '_404';
        }
        require_once $this->file;
        $class = $this->controller . 'Controller';
        $controller = new $class($this->registry);

        if(method_exists($controller, $this->action) === false){
            $action = 'index';
        }
        else {
            $action = $this->action;
        }
        $controller->$action;
    }

    private function getController(){
        $route = (empty($_GET['rt'])) ? '' : $_GET['rt'];

        if(empty($route) === false){
            $parts = explode('/', $route);
            $this->controller = ucfirst($parts[0]);
            if(isset($parts[1])){
                $this->action = $parts[1];
            }
        }
        if(empty($this->controller)){
            $this->controller = 'Index';
        }
        if(empty($this->action)){
            $this->action = 'index';
        }

        $this->file = $this->path . '/' . $this->controller . 'Controller.php';
    }
}

?>