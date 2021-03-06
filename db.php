<?php
//Get Heroku ClearDB connection information
require_once('libs/rb-mysql.php');
$cleardb_url = parse_url(getenv("CLEARDB_DATABASE_URL"));
$cleardb_server = $cleardb_url["host"];
$cleardb_username = $cleardb_url["user"];
$cleardb_password = $cleardb_url["pass"];
$cleardb_db = substr($cleardb_url["path"], 1);
$active_group = 'default';
$query_builder = TRUE;

// Connect to DB
$conn = mysqli_connect($cleardb_server, $cleardb_username, $cleardb_password, $cleardb_db);
//R::setup( 'mysql:host=localhost;dbname=mydatabase',
//    'user', 'password' );
R::setup("mysql:host=$cleardb_server;
        dbname=$cleardb_db","$cleardb_username","$cleardb_password");

//$post = R::dispense('post');
//$post["title"] = "Hello, world";
//$post["content"] = "This is line one.";
//
//$id = R::store($post);
if ( !R::testConnection() )
{
    exit ('Нет соединения с базой данных');
}
try{
    $db = new PDO("mysql:host=$cleardb_server;dbname=$cleardb_db","$cleardb_username","$cleardb_password");
} catch(PDOException $e){
    echo $e->getmessage();
}
?>