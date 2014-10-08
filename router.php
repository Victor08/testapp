<?php

/* Routing process:
 *    /public/index.php - entering point, global configuration and libraries loaded here
 *    /router.php - gets routing parameters out of a URI: module name, page name. Loads module's index.php
 *    current module /index.php - loads module's libraries, configuration
 *    current module /router.php - 
 */

router::set_route_params ();

if (preg_match('#^\/admin\/#', $_SERVER['REQUEST_URI'])) {
    include_once __DIR__.'/module/admin/index.php';  
    
}else {
    include_once router::if_exists (__DIR__.'/module/'.$_GET['module'].'/index.php');
    include_once __DIR__. '/public/view/index.phtml';

}

