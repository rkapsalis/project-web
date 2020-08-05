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
$result1 = $conn->query("SELECT DISTINCT FROM_UNIXTIME(timestampMs/1000, '%Y') as time FROM activity ORDER BY time");
$result2 = $conn->query("SELECT DISTINCT type FROM activity"); //GET YEARS TO FILL DROP-DOWN MENU
 $years =[];
 $activities = [];

while($row=mysqli_fetch_assoc($result1)) {
    array_push($years, $row['time']);
}
while($row1=mysqli_fetch_assoc($result2)) {
    array_push($activities, $row1['type']);
}

$user_stats = array('years'=> $years, 'activities'=>$activities);
echo json_encode($user_stats);
?>			