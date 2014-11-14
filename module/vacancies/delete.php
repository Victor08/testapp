<?php
use \module\vacancies\libs\admin;


$remover = new admin\remover;
$remover->delete();
header ('Location: /admin/vacancies/select');
exit();
