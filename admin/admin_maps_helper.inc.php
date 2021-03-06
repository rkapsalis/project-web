<?php
session_start();
//require_once 'db_handler.inc.php';
// Resume the previous session
header("Access-Control-Allow-Origin", "http://127.0.0.1");
header("Access-Control-Allow-Credentials: true");
header("Cache-Control: no-store");
header("Pragma: no-cache");
header("Access-Control-Allow-Methods", "GET,HEAD,OPTIONS,POST,PUT");
header("Access-Control-Allow-Headers: content-type,  x-filename,cache-control, Origin");
ini_set('display_errors', 1);
error_reporting(E_ALL);

// If the user is not logged in redirect to the login page
if (!isset($_SESSION['rememberMe'])) {
	header('Location: main.php');
	session_destroy();
	exit();
}
$uid = $_SESSION['id'];
$u_name = $_SESSION['name'];
require 'db_handler.inc.php';
$result1 = $conn->query("SELECT DISTINCT FROM_UNIXTIME(timestampMs/1000, '%Y') as time FROM data ORDER BY time");//GET YEARS TO FILL DROP-DOWN MENU
$result2 = $conn->query("SELECT DISTINCT type FROM activity"); //GET ACTIVITY TYPES TO FILL DROP-DOWN MENU
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