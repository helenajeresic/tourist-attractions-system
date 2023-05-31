<?php

// ovo nam je front controler
define('__SITE_PATH', realpath(dirname(__FILE__)));
define('__SITE_URL', dirname($_SERVER('PHP_SELF')));

require_once 'app/init.php';

session_start();

$registry = new Registry();

$registry->router = new Router($registry);

$registry->router->setPath(__SITE_PATH. '/controler');

$registry->template = new Template($registry);

$registry->router->loader();

?>