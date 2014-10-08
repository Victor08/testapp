<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace module\vacancies\config\VacanciesData;

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