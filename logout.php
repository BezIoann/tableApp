<?php
require "db.php";
require __DIR__ . '/header.php';
$_SESSION['logged_user']->status = "offline";
R::store($_SESSION['logged_user']);
unset($_SESSION['logged_user']);
// Редирект на главную страницу
exit("<meta http-equiv='refresh' content='0; url= /index.php'>");
require __DIR__ . '/footer.php';
?>
