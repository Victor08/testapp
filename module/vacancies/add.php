<?php
use \module\vacancies\libs\admin;

$addform = new admin\append;
//$query_substring = $add->form_query_substr();
$add_errors = $addform->error_messenger();
$addform->add_new($addform->form_query_substr());
