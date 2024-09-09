<?php

date_default_timezone_set('Asia/Bangkok');
/* Database credentials. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
define('DB_SERVER', 'rmutt-c11.com');
define('DB_USERNAME', 'rmuttcco_news');
define('DB_PASSWORD', 'test1234');
define('DB_NAME', 'rmuttcco_news');

/* Attempt to connect to MySQL database */
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

$gmailid = ''; // YOUR gmail email
$gmailpassword = ''; // YOUR gmail password
$gmailusername = ''; // YOUR gmail User name

?>