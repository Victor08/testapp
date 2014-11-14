<?php

/* Routing process:
 *    /public/index.php - entering point, global configuration and libraries loaded here
 *    /router.php - gets routing parameters out of a URI: module name, page name. Loads module's index.php
 *    current module /index.php - loads module's libraries, configuration
 *    current module /router.php - 
 */
use \My\Router;

Router\router::set_route_params ();


    include_once Router\router::if_exists (__DIR__.'/module/'.$_GET['module'].'/index.php');



