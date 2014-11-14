<?php
namespace module\vacancies\libs\admin;
use \module\vacancies\filter, \module\vacancies\config, \My\DataBase;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class remover extends AdminTools {
    
    // to remove single item
    public function delete () {
        if (!empty($_POST['delete'])) {
            $_POST['delete'] = DataBase\DB::mres($_POST['delete']);
            $query = "DELETE FROM `".  config\vacancies_data::$db_table."` WHERE `id` = ".$_POST['delete'];
            if (DataBase\DB::q($query)) {
                @$_SESSION['action_result'] .= '\nVacancy with id number '.$_POST['delete'].' deleted successfully';
            } else {
                @$_SESSION['action_result'] .= '\nAn error occured while trying to delete vacancy with id number '.$_POST['delete'];
            }
        }
    }
}
