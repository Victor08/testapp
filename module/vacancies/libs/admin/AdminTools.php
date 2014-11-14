<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace module\vacancies\libs\admin;
use \module\vacancies\filter, \module\vacancies\config, \My\DataBase;

class AdminTools {
    public $selected_language = "";
    public $set_properties = array ();
    
    
    
    public $properties = array (
        0=> array (
            'title' => 'title_en',
            'input_type' => 'text',
           
        ),
        1=> array (
            'title' => 'dpt_id',
            'input_type' => 'select',
            'properties' => array (
                "accounting" => 1,
                "marketing" => 2,
                "warehouse" => 3,
                "administration" => 4,
            ),
        ),
        2=> array (
            'title' => 'description_en',
            'input_type' => 'textarea',
            
        ),
        3=> array (
            'title' => 'title_fr',
            'input_type' => 'text',
        ),
        4=> array (
            'title' => 'description_fr',
            'input_type' => 'textarea',
        ),
    );
    
    public function __construct() {
        if (!empty($_POST[config\vacancies_data::$supported_languages['title']])) {
            $this->selected_language = $_POST[config\vacancies_data::$supported_languages['title']];
        } else {
            $this->selected_language = config\vacancies_data::$supported_languages['default'];
        }
        for ($i=0; $i<count($this->properties); $i++){
            if (!empty($_POST[$this->properties[$i]['title']])){
                $this->set_properties[$this->properties[$i]['title']] = htmlspecialchars($_POST[$this->properties[$i]['title']]);
            }
        }
    }
    
}    
