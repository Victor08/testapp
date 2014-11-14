<?php
namespace template\simple ;
/* 
 * The file contains template view configuration
 */

    
class template {
    static public $menu = array (
        "vacancies" => "/vacancies/show", 
        "admin" => "/admin/vacancies/select",
    );
    
    static public function path_to_css () {
        return $_SERVER['DOCUMENT_ROOT']."/css";
    }
}


