<?php
//front controller

// общие настройки

ini_set('display_errors',1);
error_reporting(E_ALL);

//подключение файлов системы

define('ROOT',dirname(__FILE__));
require_once (ROOT.'/components/router.php');
require_once (ROOT.'/components/db.php');
//вызов router

$router = new Router();
$router->run();