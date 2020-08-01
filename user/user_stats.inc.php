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
$result3 = $conn->query("SELECT ph,type_counter FROM (SELECT type, COUNT(*) as type_counter, FROM_UNIXTIME(timestampMs/1000, '%h%p') as ph FROM activity WHERE UID='$uid' AND timestampMs>=$start AND timestampMs<=$end GROUP BY type,ph ORDER BY type_counter DESC, type) AS Y GROUP BY type");
$result4 = $conn->query("SELECT pd,type_counter FROM (SELECT type, COUNT(*) as type_counter, FROM_UNIXTIME(timestampMs/1000, '%W') as pd FROM activity WHERE UID='$uid' AND timestampMs>=$start AND timestampMs<=$end GROUP BY type,pd ORDER BY type_counter DESC, type) AS Y GROUP BY type");
$result5 =  $conn->query("SELECT latitudeE7, longitudeE7, COUNT(*) AS heat_count FROM data WHERE UID='$uid' AND timestampMs>=$start AND timestampMs<=$end GROUP BY latitudeE7, longitudeE7");

 $years =[];
 $sum = [];
 $types = [];
 $peak_h = [];
 $sum_ph = [];
 $peak_d = [];
 $sum_pd = [];
 $lon = [];
 $lat = [];
 $heat_count = [];

while($row=mysqli_fetch_assoc($result2)) {
    array_push($years, $row['time']);
}
while($row1=mysqli_fetch_assoc($result1)) {
    array_push($sum, $row1['type_counter']);
    array_push($types, $row1['type']);
}
while($row2=mysqli_fetch_assoc($result3)) {
    array_push($peak_h, $row2['ph']);
   array_push($sum_ph, $row2['type_counter']);
   
}
while($row3=mysqli_fetch_assoc($result4)) {
    array_push($peak_d, $row3['pd']);
    array_push($sum_pd, $row3['type_counter']);
   
}
while($row4=mysqli_fetch_assoc($result5)) {
    array_push($lon, ['lon'=>$row4['longitudeE7']/ 10000000.0, 'lat' => $row4['latitudeE7']/ 10000000.0, 'heat_count' => $row4['heat_count']]);
    // array_push($lat, $row4['latitudeE7']);
    // array_push($heat_count, $row4['heat_count']);
}

$user_stats = array('years'=> $years,'start'=>$start, 'end'=>$end,'type'=>$types, 'sum'=>$sum, 'hour'=>$peak_h,'sum_ph'=>$sum_ph, 'day'=>$peak_d, 'sum_pd'=>$sum_pd, 'lon'=>$lon, 'lat'=>$lat, 'heat_count'=>$heat_count);
echo json_encode($user_stats);
?>			