<?php
session_start();
$cleardb_url = parse_url(getenv("mysql://b11148a0327740:d98dda68@eu-cdbr-west-01"));
$cleardb_server = $cleardb_url["host"];
$cleardb_username = $cleardb_url["user"];
$cleardb_password = $cleardb_url["pass"];
$cleardb_db = substr($cleardb_url["path"],1);
$active_group = 'default';
$query_builder = TRUE;
// Connect to DB
$conn = mysqli_connect($cleardb_server, $cleardb_username, $cleardb_password, $cleardb_db);
//require_once "vendor/autoload.php";
//use \RedBeanPHP\R;
//R::setup( "mysql:host=eu-cdbr-west-01.cleardb.com; dbname=heroku_ab4b3ff47a92985",
//    "b11148a0327740", "d98dda68@" );
////if(!R::testConnection()) die('No DB connection!');

?>
