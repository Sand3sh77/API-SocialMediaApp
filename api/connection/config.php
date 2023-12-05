<?php
header('Access-Control-Allow-Origin: *');

// $HOST = 'localhost';
// $USER = 'root';
// $PASSWORD = '';
// $DB = "social";

$HOST = 'auth-db1001.hstgr.io';
$USER = "u173237549_social";
$PASSWORD = getenv('PASSWORD');
$DB = "u173237549_social";

$con = mysqli_connect($HOST, $USER, $PASSWORD, $DB);

if (!$con) {
    die("Conection Failed");
}

?>
