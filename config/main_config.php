<?php
error_reporting(E_ALL);
date_default_timezone_set ("Europe/Moscow");

//session storage configuration
ini_set('session.gc_maxlifetime', 60*20);
ini_set('session.cookie_lifetime', 60*20);
ini_set('session.save_path', $_SERVER['DOCUMENT_ROOT'] .'../sessions/');


class Core {
    // default database connection parameters
    const DB_SERVER = "localhost";
    const DB_LOGIN = "root";
    const DB_PASS = "ololo667";
    const DB_NAME = "veeam-test";
    
}