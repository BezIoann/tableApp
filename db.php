<?php
ini_set('session.save_handler', 'memcached');
ini_set('session.save_path', getenv('MEMCACHIER_SERVERS'));
if(version_compare(phpversion('memcached'), '3', '>=')) {
    ini_set('memcached.sess_persistent', 1);
    ini_set('memcached.sess_binary_protocol', 1);
} else {
    ini_set('session.save_path', 'PERSISTENT=myapp_session ' . ini_get('session.save_path'));
    ini_set('memcached.sess_binary', 1);
}
ini_set('memcached.sess_sasl_username', getenv('MEMCACHIER_USERNAME'));
ini_set('memcached.sess_sasl_password', getenv('MEMCACHIER_PASSWORD'));
session_start();
$cleardb_url = parse_url(getenv("mysql://b11148a0327740:d98dda68@eu-cdbr-west-01"));
$cleardb_server = $cleardb_url["host"];
$cleardb_username = $cleardb_url["user"];
$cleardb_password = $cleardb_url["pass"];
$cleardb_db = substr($cleardb_url["path"],1);
$active_group = 'default';
$query_builder = TRUE;
// Connect to DB
//$conn = mysqli_connect($cleardb_server, $cleardb_username, $cleardb_password, $cleardb_db);
require_once "vendor/autoload.php";
use \RedBeanPHP\R;
R::setup( "mysql:host=eu-cdbr-west-01.cleardb.com; dbname=heroku_ab4b3ff47a92985",
    "b11148a0327740", "d98dda68@" );
//if(!R::testConnection()) die('No DB connection!');

?>
