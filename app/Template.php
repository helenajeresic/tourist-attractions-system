<?php
class Template {
    private $registry;
    private $vars = array();
    function __construct($registry) {
        $this->registry = $registry;
    }
    public function __set($index, $value) {
        $this->vars[$index] = $value;
    }
    function show($name) {
        $path = __SITE_PATH . '/view' . '/' . $name . '.php';

        if(file_exists($path) === false) {
            throw new Exception ('Template not found in' . $path);
        }
        foreach($this->vars as $key => $value) {
            $$key = $value;
        }
        require($path);
    }
}
?>