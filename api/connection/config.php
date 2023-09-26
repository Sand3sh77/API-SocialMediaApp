<?php 

$HOST='localhost';
$USER='root';
$PASSWORD='';
$DB="social";

$con=mysqli_connect($HOST,$USER,$PASSWORD,$DB);

if(!$con){
    die("Conection Failed");
}

?>