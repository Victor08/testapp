<?php
session_start();

//setting autoloader 
require_once __DIR__.'/../libs/My/AutoLoader/AutoLoader.php';
require_once __DIR__ . '/../libs/My/AutoLoader/config.php';
require_once __DIR__ . '/../libs/My/CustomFunctions/CustomFunctions.php';

$AutoLoaderConfig = new \My\AutoLoader\config (array (
    $_SERVER['DOCUMENT_ROOT'] . "/../libs",
    $_SERVER['DOCUMENT_ROOT'] . "/..",
   
    ));
$AutoLoader = new \My\AutoLoader\AutoLoader($AutoLoaderConfig);
spl_autoload_register(array ($AutoLoader, "autoload"));
// config
//require_once __DIR__.'/../config/main_config.php';
//require_once __DIR__.'/../config/template.php';
//libraries
//require_once __DIR__.'/../libs/mainlib.php';
//require_once __DIR__.'/../libs/additional_functions.php';

//router

require_once __DIR__.'/../router.php';

?>