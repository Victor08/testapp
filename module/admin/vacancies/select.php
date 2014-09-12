<?php

department::get_departments();
$filter = new vacancies_filter();
$result_array = $filter::filter();
//$_SESSION['result_num']= count ($result_array);

