<?php

$list = new vacancies_db_filter;
$query_substring = $list->form_query_substr($list->selected_properties);
$output_array = $list->db_query($query_substring);


