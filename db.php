<?php
require "libs/rb-mysql.php";
R::setup( 'mysql:host=localhost;dbname=ex4',
    'mysql', 'mysql' );
if(!R::testConnection()) die('No DB connection!');
session_start();
?>