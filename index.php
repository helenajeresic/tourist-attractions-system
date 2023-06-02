<?php
session_start();

// ovo nam je front controler
define('__SITE_PATH', realpath(dirname(__FILE__)));
define('__SITE_URL', dirname($_SERVER['PHP_SELF']));

require_once 'app/init.php';

$registry = new Registry();

$registry->router = new Router($registry);

$registry->router->setPath(__SITE_PATH . '/controller');


$registry->template = new Template($registry);

$registry->router->loader();

?>
