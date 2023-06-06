<?php
require_once __SITE_PATH . '/controller/BaseController.php';
require_once __SITE_PATH . '/app/Registry.php';
require_once __SITE_PATH . '/app/Router.php';
require_once __SITE_PATH . '/app/Template.php';
require_once __SITE_PATH . '/app/database/mongodb.class.php';
require_once __SITE_PATH . '/app/database/neo4j.class.php';
//require_once __SITE_PATH . '/app/database/load_database.php';

spl_autoload_register(function ($class_name){
    $filename = $class_name . '.php';
    $file = __SITE_PATH . '/model/' . $filename;
    if(file_exists($file) === false){
        return false;
    }
    require_once($file);
    return true;
});
?>