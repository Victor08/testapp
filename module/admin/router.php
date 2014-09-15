<?php

 include_once router::if_exists( __DIR__.'/'.$_GET['module'].'/'.$_GET['page'].'.php');
   
 include_once router::if_exists( __DIR__.'/'.$_GET['module'].'/view/'.$_GET['page'].'.phtml');

