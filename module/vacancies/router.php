<?php

if (file_exists(__DIR__.'/'.$_GET['page'].'.php')) {
    include_once __DIR__.'/'.$_GET['page'].'.php';
} else {
    include_once __DIR__.'/module/errors/404.phtml';
    exit();
}

if (file_exists(__DIR__.'/view/'.$_GET['page'].'.phtml')) {
    include_once __DIR__.'/view/'.$_GET['page'].'.phtml';
} else {
    include_once __DIR__.'/module/errors/404.phtml';
    exit();
}
