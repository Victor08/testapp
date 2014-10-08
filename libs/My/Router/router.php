<?php

/* The class is used for controller purposes
 * 
 */

namespace My\Router;

class router {
    static public $default_module = 'vacancies';
    static public $default_page = 'show';
    static public function errors_path() {
        return $_SERVER['DOCUMENT_ROOT'].'/../module/errors';
    }

    // Function gets routing parameters out of a URI string
    static public function set_route_params () {
        if (isset($_GET['route'])) {
            $route = explode('/', $_GET['route']);
            for ($i=0; $i<count($route); $i++){
                if ($i==0) {
                    $_GET['module'] = hschAll($route[$i]);
                } elseif ($i==1) {
                    $_GET['page'] = hschAll($route[$i]);
                } elseif ( $i>1 ){
                    if (!isset($_GET['extra'])) {
                        $_GET['extra'] = array();
                    }
                    array_push ($_GET['extra'], hschAll($route[$i]));
                }
            }
        }
        if (empty($_GET['module'])) {
            $_GET['module'] = self::$default_module;
        }
        if (empty($_GET['page'])) {
            $_GET['page'] = self::$default_page;
        }
    }
    
    // function for checking invalid URIs
    static public function if_exists ($file) {
        if (file_exists($file)){
            return $file;
        } else {
            return self::errors_path().'/404.phtml';
        }
    }
}


