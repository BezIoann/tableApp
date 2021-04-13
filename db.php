<?php
require "libs/rb-mysql.php";
R::setup( 'mysql:host=eu-cdbr-west-01.cleardb.com:3306;dbname=heroku_ab4b3ff47a92985',
    'mysql', 'mysql' );
if(!R::testConnection()) die('No DB connection!');
session_start();

/* Heroku remote server */

?>