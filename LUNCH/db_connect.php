<?php

// $servername = "sql311.epizy.com";
// $username = "epiz_32268592";
// $password = "SsjtKKVEFMuBl7J";
// $database = "epiz_32268592_inferencia_db";

$servername = "localhost";
$username = "root";
$password = "";
$database = "inferencia_db";


$conn = mysqli_connect($servername, $username, $password, $database);


if (!$conn){
    die("Failed to connect". mysqli_connect_error());
}

?>