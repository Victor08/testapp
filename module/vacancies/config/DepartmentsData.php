<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace module\vacancies\config\DepartmentsData;

class DepartmentsData {
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
