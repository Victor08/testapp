<?php

/* Requires vacancies module base library "vacancies.php"
 * 
 */

require_once $_SERVER['DOCUMENT_ROOT'].'/../module/vacancies/libs/vacancies.php';


class vacancies_admin_tools {
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
        if (!empty($_POST[vacancies_data::$supported_languages['title']])) {
            $this->selected_language = $_POST[vacancies_data::$supported_languages['title']];
        } else {
            $this->selected_language = vacancies_data::$supported_languages['default'];
        }
        for ($i=0; $i<count($this->properties); $i++){
            if (!empty($_POST[$this->properties[$i]['title']])){
                $this->set_properties[$this->properties[$i]['title']] = htmlspecialchars($_POST[$this->properties[$i]['title']]);
            }
        }
    }
    
}    


class vacancies_remover extends vacancies_admin_tools {
    public function delete () {
        if (!empty($_POST['delete'])) {
            $_POST['delete'] = DB::mres($_POST['delete']);
            $query = "DELETE FROM `".  vacancies_data::$db_table."` WHERE `id` = ".$_POST['delete'];
            if (DB::q($query)) {
                @$_SESSION['action_result'] .= '\nVacancy with id number '.$_POST['delete'].' deleted successfully';
            } else {
                @$_SESSION['action_result'] .= '\nAn error occured while trying to delete vacancy with id number '.$_POST['delete'];
            }
        }
    }
}


class vacancies_append extends vacancies_admin_tools {

    public function error_messenger () {
        $errors = array ();
        if (isset($_POST['add_new_vacancy'])) {
            if (empty($_POST['title_'.$this->selected_language])) {
                $errors['title'] = "this field is required";
            }
            if (empty($_POST[departments_data::$supported_departments['title']])) {
                $errors[departments_data::$supported_departments['title']] = "this field is required";
            }
            if (empty($_POST['language'])) {
                $errors['language'] = "this field is required";
            }
            if (!in_array($_POST[departments_data::$supported_departments['title']], departments_data::$supported_departments['properties'])) {
                $errors[[departments_data::$supported_departments['title']]] = "department does not exist.";
            }
        }
        if (count($errors) == 0) {
            return FALSE;
        } else {
            return $errors;
        }
    }
   
    
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
    
    public function add_new ($substring) {
        if (!empty($substring)){
            $query = "INSERT INTO `". vacancies_data::$db_table ."` SET ".$substring;

            if ($this->error_messenger() === FALSE) {
                if ( DB::q($query)) {
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

class vacancies_updater extends vacancies_admin_tools {
    
    public $item_id = "";
        
        public function __construct () {
            for ($i=0; $i<count($this->properties); $i++){
            if (!empty($_POST[$this->properties[$i]['title']])){
                $this->set_properties[$this->properties[$i]['title']] = htmlspecialchars($_POST[$this->properties[$i]['title']]);
            }
            if (!empty($_POST['update'])) {
                $this->item_id = (int)($_POST['update']);
            } else {
                @$_SESSION['action_result'] .= "<br>Choose an item for update";
                header ("Location: /admin/vacancies/select");
                die;
            }
        }
    }
    
    public function error_messenger () {
        $errors = array ();
        if (isset($_POST['update_vacancy'])) {
            
                if (empty($_POST['title_en'])) {
                    $errors['title_en'] = "this field is required";
                }
            
            if (empty($_POST[departments_data::$supported_departments['title']])) {
                $errors[departments_data::$supported_departments['title']] = "this field is required";
            }           
            if (!in_array($_POST[departments_data::$supported_departments['title']], departments_data::$supported_departments['properties'])) {
                $errors[[departments_data::$supported_departments['title']]] = "department does not exist.";
            }
        }
        if (count($errors) == 0) {
            return FALSE;
        } else {
            return $errors;
        }
    }
    
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
    
    public function update ($substring) {
       
        if (!empty($substring)){
            $query = "UPDATE `". vacancies_data::$db_table ."` SET ".$substring." WHERE `id`=".$this->item_id;

            if ($this->error_messenger() === FALSE) {
                if ( DB::q($query)) {
                    @$_SESSION['action_result'] .= "<br>updated successfully.";
                    header ("Location: /admin/vacancies/select");
                    exit();
                } else {
                    @$_SESSION['action_result'] .= "<br>An error occured while trying to update  vacancy ".$this->set_properties['title'.$this->selected_language];

                }
            }
        }
    }
    
    public function get_data () {
        $query = "SELECT * FROM `".vacancies_data::$db_table."` WHERE `id`= ".$this->item_id;
        $result = DB::q($query);
        $result_array = $result->fetch_all(MYSQLI_BOTH);
        return $result_array;
    }
}



 

