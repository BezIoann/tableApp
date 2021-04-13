<?php
require "libs/rb-mysql.php";
R::setup( 'mysql:localhost;dbname=heroku_ab4b3ff47a92985',
    'mysql', 'mysql' );
if(!R::testConnection()) die('No DB connection!v1');
session_start();

/* Heroku remote server */

?>