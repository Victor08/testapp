<?php
use \module\vacancies\libs\admin;

$updater = new admin\updater;
$errors = $updater->error_messenger();
$output_array = $updater->get_data();
$updater->update($updater->form_query_substr());
