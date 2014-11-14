<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace module\vacancies\libs\filter;
use module\vacancies\config;
use My\Database;

class db_filter  {
    public $selected_language = "en";
    public $selected_properties = array ();
 
    
    public function __construct () {
        if (!empty($_POST[config\vacancies_data::$supported_languages['title']])) {
            $this->selected_language = $_POST[config\vacancies_data::$supported_languages['title']];
        } else {
            $this->selected_language = config\vacancies_data::$supported_languages['default'];
        }
        for ($i=0; $i<count($this->properties); $i++){
            if (!empty($_POST[$this->properties[$i]['title']])){
                $this->selected_properties[$this->properties[$i]['title']] = htmlspecialchars($_POST[$this->properties[$i]['title']]);
            }
        }
    
    }

    // contains current filtering options
    public $properties = array (   //!!!write a function to get this data automatically
        0 => array (
            'title' => "dpt_id",    // always use an appropriate db field name for 'title' value
            'properties' => array (              
                "accounting" => 1,
                "marketing" => 2,
                "warehouse" => 3,
                "administration" => 4,
            ),
            'multiple' => "multiple",
            'required' => 'required',
        ),
        
    );

    // generating a database query substring containing query parameters
    public function form_query_substr () {
        $substring = "";
        foreach ($this->selected_properties as $k => $v){
            $substring .= "`".$k."`= '".$v."' AND ";
        }
        if (!empty($substring)) {
            $substring = "WHERE ".mb_substr ($substring, 0, strlen($substring)-5);
        }
        
        return $substring;
    }
    
    // proceeding a SELECT query to get an array with output data
    public function get_output_array ($substring){
        $query = "SELECT `id`, `dpt_id`, `title_".$this->selected_language."`, `description_".$this->selected_language."` FROM `".  config\vacancies_data::$db_table."` ".$substring;        
        if ($this->selected_language == config\vacancies_data::$supported_languages['default']){
            $result = DataBase\DB::q($query);
            $result_array = $result->fetch_all(MYSQLI_BOTH);
        } else {
            $result = DataBase\DB::q($query);
            $result_array = $result->fetch_all(MYSQLI_BOTH);
            for ($i=0; $i<count($result_array); $i++) {
                if (empty($result_array[$i]['title_'.$this->selected_language])) {
                    $query = "SELECT `id`, `dpt_id`, `title_".  config\vacancies_data::$supported_languages['default']."`, `description_".  config\vacancies_data::$supported_languages['default']."` FROM `".config\vacancies_data::$db_table."` WHERE `id`=".$result_array[$i]['id'];
                    $element = DataBase\DB::q($query);
                    $element_array = $element->fetch_all(MYSQLI_BOTH);
                    $result_array[$i] = $element_array[0];
                }
            }        
        }
        return $result_array;
    }   
}    

