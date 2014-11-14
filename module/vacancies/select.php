<?php
use \module\vacancies\libs\filter;

$list = new filter\db_filter;
$output_array = $list->get_output_array($list->form_query_substr());