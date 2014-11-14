<?php
use \My\Router;


include_once Router\router::if_exists( __DIR__.'/'.$_GET['page'].'.php' );

if (preg_match('#^\/admin\/#', $_SERVER['REQUEST_URI'])) {
    include_once $_SERVER['DOCUMENT_ROOT'].'/../template/simple/view/admin/index.phtml';    
} else {
    include_once $_SERVER['DOCUMENT_ROOT'].'/../template/simple/view/user/index.phtml';
}