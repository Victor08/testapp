<?php

if (file_exists ( __DIR__.'/'.$_GET['module'].'/'.$_GET['page'].'.php')){
        include_once __DIR__.'/'.$_GET['module'].'/'.$_GET['page'].'.php';
    } else {
        include_once __DIR__.'/../module/errors/view/404.phtml';
    }

if (file_exists ( __DIR__.'/'.$_GET['module'].'/view/'.$_GET['page'].'.phtml')){
        include_once __DIR__.'/'.$_GET['module'].'/view/'.$_GET['page'].'.phtml';
    } else {
        include_once __DIR__.'/../module/errors/view/404.phtml';
    }

