<?php
namespace module\vacancies\libs\admin;
use \module\vacancies\filter, \module\vacancies\config, \My\DataBase;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class append extends AdminTools {

    public $properties = array (
            0=> array (
            'title' => 'title',
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
            'title' => 'description',
            'input_type' => 'textarea',
            
        ),
    );
    
    // checking data sent via the web form
    public function error_messenger () {
        $errors = array ();
        if (isset($_POST['add_new_vacancy'])) {
            if (empty($_POST['title'])) {
                $errors['title'] = "this field is required";
            }
            if (empty($_POST[config\departments_data::$supported_departments['title']])) {
                $errors[config\departments_data::$supported_departments['title']] = "this field is required";
            }
            if (empty($_POST['language'])) {
                $errors['language'] = "this field is required";
            }
            if (!in_array($_POST[config\departments_data::$supported_departments['title']], config\departments_data::$supported_departments['properties'])) {
                $errors[[config\departments_data::$supported_departments['title']]] = "department does not exist.";
            }
        }
        if (count($errors) == 0) {
            return FALSE;
        } else {
            return $errors;
        }
    }
   
    // generating a database query substring, containing query parameters
    public function form_query_substr () {
        $substring = "";
        foreach ($this->set_properties as $k => $v){
            if ($k == "title" || $k == 'description') {
                $substring .="`".$k."_".$this->selected_language."`= '".$v."', ";
            } else {
        
                $substring .= "`".$k."`= '".$v."', ";
            }
        }
        if (!empty($substring)) {
            $substring = mb_substr ($substring, 0, strlen($substring)-2);
        }
        
        return $substring;
    }
    
    // proceeding an INSERT query to add a single item
    public function add_new ($substring) {
        if (!empty($substring)){
            $query = "INSERT INTO `". config\vacancies_data::$db_table ."` SET ".$substring;

            if ($this->error_messenger() === FALSE) {
                if ( DataBase\DB::q($query)) {
                    @$_SESSION['action_result'] .= "<br>New vacancy ".$this->set_properties['title'.$this->selected_language]." added successfully.";
                    header ("Location: /admin/vacancies/select");
                    exit();
                } else {
                    @$_SESSION['action_result'] .= "<br>An error occured while trying to add new vacancy ".$this->set_properties['title'.$this->selected_language];

                }
            }
        }
    }
    
}
