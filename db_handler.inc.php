<?php

$dbServerName = "localhost";
$dbUserName = "root";
$dbPassowrd = "";
$dbName = "web";

//Variable that holds connection to database
$conn = mysqli_connect($dbServerName, $dbUserName, $dbPassowrd, $dbName);
mysqli_set_charset($conn,"utf8");
