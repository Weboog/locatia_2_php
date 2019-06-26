<?php
date_default_timezone_set('Africa/Casablanca');
error_reporting(E_ALL &~ E_NOTICE);
//Defining constants------------------------------------------------------
define('ROOT', __DIR__);
define('DS', DIRECTORY_SEPARATOR);
define('CORE', ROOT.DS.'core');
define('CONTROLLERS', ROOT.DS.'controllers');
define('MODELS', ROOT.DS.'models');
define('VIEWS', ROOT.DS.'views');
//Including core classes---------------------------------------------------
require_once CORE . DS . 'controller.php';
require_once CORE . DS . 'database.php';
include_once CORE . DS . 'cookie.php';
include_once CORE . DS . 'widget.php';
//autoload classes----------------------------------------------------------
function autoload($class){
        $file = CONTROLLERS . DS . strtolower($class) . '.php';
        if(file_exists($file)) require_once CONTROLLERS . DS . strtolower($class) . '.php';
}
spl_autoload_register('autoload');
//Retrieving uri from address-----------------------------------------------
$uri = rtrim($_GET['url'], '/');
$url = explode('/', $uri);
//Extracting controllers and actions---------------------------------------
$controller = empty($url[0]) ? 'appartments' : $url[0];
$action = empty($url[1]) ? 'index' : $url[1] ;
//Instancing controllers--------------------------------------------------
$controller = new $controller();
//Firing actions of controllers with or without params-----------------------
if (method_exists($controller, $action)){
    unset($url[0]);
    unset($url[1]);
    call_user_func_array(array($controller, $action), $url);
}
