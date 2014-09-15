<?php
/*
if ($_GET['page'] == "delete") {
    if (isset($_POST['delete'])) {
        $_GET['page'] = "delete";
    } elseif (isset($_POST['update'])) {
        $_GET['page'] = 'update';
    }
}
  */

 include_once router::if_exists( __DIR__.'/'.$_GET['page'].'.php');


 include_once $_SERVER['DOCUMENT_ROOT'].'/../module/admin/vacancies/view/index.phtml';