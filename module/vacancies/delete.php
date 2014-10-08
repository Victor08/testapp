<?php
$remover = new vacancies_remover;
$remover->delete();
header ('Location: /admin/vacancies/select');
exit();
