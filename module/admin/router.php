<?php
use \My\Router;
 include_once Router\router::if_exists( __DIR__.'/'.$_GET['module'].'/index.php');
   
 //include_once router::if_exists( __DIR__.'/'.$_GET['module'].'/view/'.$_GET['page'].'.phtml');

