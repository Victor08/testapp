<?php
use \My\Router;

include_once Router\router::if_exists( __DIR__.'/'.$_GET['page'].'.php' );

