<?php
session_start();
//require_once 'db_handler.inc.php';
// Resume the previous session
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
// set_time_limit(900);
// If the user is not logged in redirect to the login page
if (!isset($_SESSION['rememberMe'])) {
	header('Location: main.html');
	session_destroy();
	exit();
}
$uid = $_SESSION['id'];
$u_name = $_SESSION['name'];
require 'db_handler.inc.php';
// mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$sql = "SELECT DISTINCT FROM_UNIXTIME(timestampMs/1000, '%Y') as time FROM data WHERE UID='$uid' ORDER BY time";  //GET YEARS TO FILL DROP-DOWN MENU
 $result2 = mysqli_query($conn,$sql );
 $years =[];
 // var_dump($uid);

while($row=mysqli_fetch_assoc($result2)) {
    array_push($years, $row['time']);
}
$user_stats = array('years'=> $years);
echo json_encode($user_stats);
?>			