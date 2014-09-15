<?php

/* Requires vacancies module base library "vacancies.php"
 * 
 */

class admin_select extends vacancies_db_filter {
    public function db_query ($substring){
        $query = "SELECT `id`, `dpt_id`, `title_".$this->selected_language."`, `description_".$this->selected_language."` FROM `".self::$db_table."` ".$substring;        
        $result = DB::q($query);
        $result_array = $result->fetch_all(MYSQLI_BOTH);
        return $result_array;
    }
}

