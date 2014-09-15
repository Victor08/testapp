<?php
abstract class department {
    static public $id;
    static public $title;
    
}

abstract class vacancy {
    static public $id;
    static public $title ;
    static public $department ;
    static public $language;
    static public $description;
    static public $db_fields = array ();
   
}

class departments_data {
    static public $db_table = "departments";
    static public $supported_departments = array (    //!!!write a function to get this data automatically
        'title' => 'dpt_id',
        'properties' => array (
            'accounting' => 1,
            'marketing' => 2,
            'warehouse' => 3,
            'administration' => 4,
        ),
        'default' => '',
        'multiple' => '',
        'required' => '',
    );
}

class vacancies_data {
    static public $db_table = "vacancies"; 
    static public $supported_languages = array (      //!!!write a function to get this data automatically
        'title' => 'language', 
        'properties' => array(
            "english" => "en",
            "french" => "fr",
           
        ),
        'default' => "en",
        'multiple' => "",
        'required' => 'required',
    );
            

}


class vacancies_db_filter  {
    public $selected_language = "en";
    public $selected_properties = array ();
 
    
    public function __construct () {
        if (!empty($_POST[vacancies_data::$supported_languages['title']])) {
            $this->selected_language = $_POST[vacancies_data::$supported_languages['title']];
        } else {
            $this->selected_language = vacancies_data::$supported_languages['default'];
        }
        for ($i=0; $i<count($this->properties); $i++){
            if (!empty($_POST[$this->properties[$i]['title']])){
                $this->selected_properties[$this->properties[$i]['title']] = htmlspecialchars($_POST[$this->properties[$i]['title']]);
            }
        }
    
    }


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
    
    public function get_output_array ($substring){
        $query = "SELECT `id`, `dpt_id`, `title_".$this->selected_language."`, `description_".$this->selected_language."` FROM `".  vacancies_data::$db_table."` ".$substring;        
        if ($this->selected_language == vacancies_data::$supported_languages['default']){
            $result = DB::q($query);
            $result_array = $result->fetch_all(MYSQLI_BOTH);
        } else {
            $result = DB::q($query);
            $result_array = $result->fetch_all(MYSQLI_BOTH);
            for ($i=0; $i<count($result_array); $i++) {
                if (empty($result_array[$i]['title_'.$this->selected_language])) {
                    $query = "SELECT `id`, `dpt_id`, `title_".  vacancies_data::$supported_languages['default']."`, `description_".  vacancies_data::$supported_languages['default']."` FROM `".self::$db_table."` WHERE `id`=".$result_array[$i]['id'];
                    $element = DB::q($query);
                    $element_array = $element->fetch_all(MYSQLI_BOTH);
                    $result_array[$i] = $element_array[0];
                }
            }        
        }
        return $result_array;
    }   
}    



