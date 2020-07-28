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

$month_u = $_POST["month_u"];
$year_s = $_POST["year_s"];
$year_u = $_POST["year_u"];
$month_s = $_POST["month_s"];
$month = date("(F)", date("m"));
$year = date("Y");
$date_start = "$year_s-$month_s";
$date_end = "$year_u-$month_u";
$start = strtotime(date("Y-m-01", strtotime($date_start)))*1000;
$end = strtotime(date("Y-m-31", strtotime($date_end)))*1000;

//var_dump($sel);	
$result1 = $conn->query("SELECT type,COUNT(*) as type_counter FROM activity WHERE UID='$uid' AND timestampMs>=$start AND timestampMs<=$end GROUP BY type");
$result2 = $conn->query("SELECT DISTINCT FROM_UNIXTIME(timestampMs/1000, '%Y') as time FROM activity WHERE UID='$uid' ORDER BY time"); //GET YEARS TO FILL DROP-DOWN MENU
//$result3 = $conn->query("SELECT FROM_UNIXTIME(timestampMs/1000, %h:%i:%s), type,COUNT(*) as type_counter FROM activity WHERE UID='$uid' AND timestampMs>=$start AND timestampMs<=$end GROUP BY type");
 $years =[];
 $sum = [];
 $types =[];

while($row=mysqli_fetch_assoc($result2)) {
    array_push($years, $row['time']);
}
while($row1=mysqli_fetch_assoc($result1)) {
    array_push($sum, $row1['type_counter']);
    array_push($types, $row1['type']);
}
$user_stats = array('years'=> $years,'start'=>$start, 'end'=>$end,'type'=>$types, 'sum'=>$sum);
echo json_encode($user_stats);
?>			