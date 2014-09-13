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


class vacancies_db_filter extends vacancies_data {
    public $selected_language = "en";
    public $selected_properties = array ();
 
    
    public function __construct () {
        if (!empty($_POST[self::$supported_languages['title']])) {
            $this->selected_language = $_POST[self::$supported_languages['title']];
        } else {
            $this->selected_language = self::$supported_languages['default'];
        }
        for ($i=0; $i<count($this->properties); $i++){
            if (!empty($_POST[$this->properties[$i]['title']])){
                $this->selected_properties[$this->properties[$i]['title']] = $_POST[$this->properties[$i]['title']];
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
    
    public function input_form_gen () {
        ?>
        <form id="filter" method="post">
            <table>
                <tr>
                    <td>
                        <p>filter vacancies</p>
                    </td>
                    <td>
                        language
                    </td>
                    <td>
                        <select form="filter" name="<?php echo vacancies_data::$supported_languages['title'] ?>" <?php echo vacancies_data::$supported_languages['required'] ?>>
                            <option value="">default</option>
                            <?php 
                            foreach (vacancies_data::$supported_languages['properties'] as $k => $y) { 
                                if (isset($_POST[vacancies_data::$supported_languages['title']])){
                                    if ($_POST[vacancies_data::$supported_languages['title']] == $y) {
                                        $selected = "selected";
                                    } else {
                                        $selected = "";
                                    }
                                }
                            ?>               
                            <option <?php echo @$selected; ?> value="<?php echo $y ?>"><?php echo $k; ?></option>                
                        <?php
                        } 
                        ?>
                        </select>
                    </td>
                    <?php
                    foreach ($this->properties as $v){
                        ?>
                    <td><?php echo $v['title']; ?></td>
                    <td>
                        <select form="filter" name="<?php echo $v['title'] ?>" <?php echo $v['multiple']; echo $v['required']; ?> >
                            <option value="">not specified</option>
                        <?php 
                        foreach ($v['properties'] as $k => $y) {
                            if (isset($_POST[$v['title']])) {
                                if ($_POST[$v['title']] == $y) {
                                        $selected = "selected";
                                } else {
                                    $selected = "";
                                }
                            }
                            
                            ?>               
                            <option <?php echo @$selected; ?> value="<?php echo $y; ?>"><?php echo $k; ?></option>                
                        <?php
                        } 
                        ?>
                        </select>
                    </td>
                    <?php
                    }
                    ?>
                    <td>
                        <input type="submit" value="show">
                    </td>
                </tr>
            </table>
        </form>
<?php
    }
    
    


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
    
    public function db_query ($substring){
        $query = "SELECT `id`, `dpt_id`, `title_".$this->selected_language."`, `description_".$this->selected_language."` FROM `".self::$db_table."` ".$substring;        
        if ($this->selected_language == self::$supported_languages['default']){
            $result = DB::q($query);
            $result_array = $result->fetch_all(MYSQLI_BOTH);
        } else {
            $result = DB::q($query);
            $result_array = $result->fetch_all(MYSQLI_BOTH);
            for ($i=0; $i<count($result_array); $i++) {
                if (empty($result_array[$i]['title_'.$this->selected_language])) {
                    $query = "SELECT `id`, `dpt_id`, `title_".self::$supported_languages['default']."`, `description_".self::$supported_languages['default']."` FROM `".self::$db_table."` WHERE `id`=".$result_array[$i]['id'];
                    $element = DB::q($query);
                    $element_array = $element->fetch_all(MYSQLI_BOTH);
                    $result_array[$i] = $element_array[0];
                }
            }        
        }
        return $result_array;
    }   
}

class vacancies_show extends vacancies_db_filter {
    public function output ($output_array) {
        for ($i=0; $i<count($output_array); $i++) {
            ?>
            <h2><?php echo $output_array[$i][2]; ?></h2>
            <p>vacancy id: <?php echo $output_array[$i][0]; ?></p>
            <p>department: <?php echo array_search ($output_array[$i]['dpt_id'], departments_data::$supported_departments['properties']); ?></p>
            <p>description:<br><?php echo $output_array[$i][3]; ?></p>
            <hr>
            <?php
        }
    }   
}     



