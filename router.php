<?php

router::set_route_params ();

if (preg_match('#^\/admin\/#', $_SERVER['REQUEST_URI'])) {
    include_once __DIR__.'/module/admin/index.php';    
}else {
    include_once router::if_exists (__DIR__.'/module/'.$_GET['module'].'/index.php');
}

