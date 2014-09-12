<?php

vacancies_filter::update_select("vacancies_chosen", $_POST['results_on_page'] = (int)$_POST['results_on_page']);

if (isset($_POST['update_vac'])) {
    vacancies_filter::update();
}
