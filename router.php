<?php

router::set_route_params ();

if (preg_match('#^\/admin\/#', $_SERVER['REQUEST_URI'])) {
    include_once __DIR__.'/admin/index.php';    
}elseif (file_exists(__DIR__.'/module/'.$_GET['module'].'/index.php')){
    include_once __DIR__.'/module/'.$_GET['module'].'/index.php';
} else {
    include_once __DIR__.'/module/errors/404.phtml';
    exit();
}

