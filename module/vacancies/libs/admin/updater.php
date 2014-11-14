<?php
namespace module\vacancies\libs\admin;
use \module\vacancies\filter, \module\vacancies\config, \My\DataBase;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class updater extends AdminTools {
    
    public $item_id = "";
        
        public function __construct () {
            for ($i=0; $i<count($this->properties); $i++){
                if (!empty($_POST[$this->properties[$i]['title']])){
                    $this->set_properties[$this->properties[$i]['title']] = htmlspecialchars($_POST[$this->properties[$i]['title']]);
                }
            }
            if (!empty($_POST['update'])) {
                $this->item_id = (int)($_POST['update']);
            } else {
                @$_SESSION['action_result'] .= "<br>Choose an item for update";
                header ("Location: /admin/vacancies/select");
                die;
            }
        }
    
    // checking data, sent via the web form
    public function error_messenger () {
        $errors = array ();
        if (isset($_POST['update_vacancy'])) {
            
                if (empty($_POST['title_en'])) {
                    $errors['title_en'] = "this field is required";
                }
            
            if (empty($_POST[config\departments_data::$supported_departments['title']])) {
                $errors[config\departments_data::$supported_departments['title']] = "this field is required";
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
            $substring .= "`".$k."`= '".$v."', ";
        }
        if (!empty($substring)) {
            $substring = mb_substr ($substring, 0, strlen($substring)-2);
        }
        
        return $substring;
    }
    
    //proceeding an UPDATE query for single item
    public function update ($substring) {
       
        if (!empty($substring)){
            $query = "UPDATE `". config\vacancies_data::$db_table ."` SET ".$substring." WHERE `id`=".$this->item_id;

            if ($this->error_messenger() === FALSE) {
                if ( DataBase\DB::q($query)) {
                    @$_SESSION['action_result'] .= "<br>updated successfully.";
                    header ("Location: /admin/vacancies/select");
                    exit();
                } else {
                    @$_SESSION['action_result'] .= "<br>An error occured while trying to update  vacancy ".$this->set_properties['title'.$this->selected_language];

                }
            }
        }
    }
    
    // getting current data for a single item
    public function get_data () {
        $query = "SELECT * FROM `".config\vacancies_data::$db_table."` WHERE `id`= ".$this->item_id;
        $result = DataBase\DB::q($query);
        $result_array = $result->fetch_all(MYSQLI_BOTH);
        return $result_array;
    }
}
