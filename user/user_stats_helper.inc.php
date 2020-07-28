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
$result2 = $conn->query("SELECT DISTINCT FROM_UNIXTIME(timestampMs/1000, '%Y') as time FROM activity WHERE UID='$uid' ORDER BY time"); //GET YEARS TO FILL DROP-DOWN MENU
 $years =[];


while($row=mysqli_fetch_assoc($result2)) {
    array_push($years, $row['time']);
}
$user_stats = array('years'=> $years);
echo json_encode($user_stats);
?>			