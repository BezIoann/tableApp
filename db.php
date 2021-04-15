<?php
require_once "vendor/autoload.php";
use \RedBeanPHP\R;
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
if (!isset($_SESSION['count'])) {
    $_SESSION['count'] = 0;
}
$_SESSION['count']++;

echo "Hello #" . $_SESSION['count'];
$cleardb_url = parse_url(getenv("mysql://b11148a0327740:d98dda68@eu-cdbr-west-01.cleardb.com/heroku_ab4b3ff47a92985?reconnect=true"));
$cleardb_server = $cleardb_url["host"];
$cleardb_username = $cleardb_url["user"];
$cleardb_password = $cleardb_url["pass"];
$cleardb_db = substr($cleardb_url["path"],1);
$active_group = 'default';
$query_builder = TRUE;
$conn = mysqli_connect($cleardb_server, $cleardb_username, $cleardb_password, $cleardb_db);
R::setup("mysql:host=$cleardb_server;
        dbname=$cleardb_db","$cleardb_username","$cleardb_password");
?>
