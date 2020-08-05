<?php
session_start();
//require_once 'db_handler.inc.php';
// Resume the previous session
error_reporting(E_ALL);

// If the user is not logged in redirect to the login page
if (!isset($_SESSION['rememberMe'])) {
	header('Location: main.html');
	session_destroy();
	exit();
}
$uid = $_SESSION['id'];
$u_name = $_SESSION['name'];
require 'db_handler.inc.php';
$delete1 = $conn->query("DELETE FROM data");
$delete2 = $conn->query("DELETE FROM activity");
$delete3 = $conn->query("DELETE FROM score");


if (mysqli_affected_rows() > 0) {
    echo "success";
}
else {
    echo "fail";
}
?>