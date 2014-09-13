<?php

$list = new vacancies_show;
$query_substring = $list->form_query_substr($list->selected_properties);
$output_array = $list->db_query($query_substring);
$output_html = $list->input_form_gen()."<br>".$list->output($output_array);


