<?php

// $HOST='localhost';
// $USER='root';
// $PASSWORD='';
// $DB="social";

$HOST = 'https://auth-db1001.hstgr.io/';
$USER = "u173237549_social";
$PASSWORD = 'Onepiece@4321';
$DB = "u173237549_social";

$con = mysqli_connect($HOST, $USER, $PASSWORD, $DB);

if (!$con) {
    die("Conection Failed");
}

?>