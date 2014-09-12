<?php
vacancies_filter::delete("vacancies_chosen_", (int) $_POST['results_on_page']);
header ('Location: /admin/vacancies/select');
exit();
