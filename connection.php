<?php

$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "srms_db"; 


$con = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname,);


if (!$con) {
    die("Xiriirka Database-ku MAJIRO: " . mysqli_connect_error());
}

?>