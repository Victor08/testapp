<?php


include_once router::if_exists( __DIR__.'/'.$_GET['page'].'.php' );

include_once $_SERVER['DOCUMENT_ROOT']. '/view/index.phtml';

