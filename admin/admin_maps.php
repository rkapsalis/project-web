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
	header('Location: main.html');
	session_destroy();
	exit();
}
$uid = $_SESSION['id'];
$u_name = $_SESSION['name'];
require 'db_handler.inc.php';

//get input values
$month_u = $_POST["month_u"];
$month_s = $_POST["month_s"];
$year_s = $_POST["year_s"];
$year_u = $_POST["year_u"];
$hoursince = $_POST["hoursince"];
$houruntil = $_POST["houruntil"];
$pm_am_s = $_POST["pm_am_s"];
$pm_am_u = $_POST["pm_am_u"];
$minutessince = $_POST["minutessince"];
$minutesuntil = $_POST["minutesuntil"];
$dayuntil = $_POST["dayuntil"];
$daysince = $_POST["daysince"];
// $activity1 = $_POST["activity1"];
// $activity2 = $_POST["activity2"]
 $selected = $_POST["selected"];



if($month_s == 'ALL'){
    $month_s = "01";
}
if($month_u == 'ALL'){
    $month_u = "12";
}
if($daysince == "ALL"){
    $daysince = "1";
}
if($dayuntil == "ALL"){
    $dayuntil = "6";
}
if($hoursince == "ALL"){
    $hoursince = "12";
}
if($houruntil == "ALL"){
    $houruntil = "11";
}
if($pm_am_s == "ALL"){
    $pm_am_s = "AM";
}
if($pm_am_u == "ALL"){
    $pm_am_u = "PM";
}
if($minutessince == "ALL"){
    $minutessince = "00";
}
if($minutesuntil == "ALL"){
    $minutesuntil = "59";
}
if($year_s == "ALL"){
   $year_s = date('Y', 1);
}
if($year_u == "ALL"){
    $year_u = date('Y');
}
$date_start = "$year_s-$month_s-$daysince $hoursince:$minutessince $pm_am_s";
$date_end = "$year_u-$month_u-$dayuntil $houruntil:$minutesuntil $pm_am_u";
$start = strtotime(date("Y-m-w h:i A", strtotime($date_start)))*1000000;
$end = strtotime(date("Y-m-31", strtotime($date_end)))*1000;

//var_dump($sel);	
// $result1 = $conn->query("SELECT type,COUNT(*) as type_counter FROM activity WHERE UID='$uid' AND timestampMs>=$start AND timestampMs<=$end GROUP BY type");
// $result2 = $conn->query("SELECT DISTINCT FROM_UNIXTIME(timestampMs/1000, '%Y') as time FROM activity WHERE UID='$uid' ORDER BY time"); //GET YEARS TO FILL DROP-DOWN MENU
// $result3 = $conn->query("SELECT ph,type_counter FROM (SELECT type, COUNT(*) as type_counter, FROM_UNIXTIME(timestampMs/1000, '%h%p') as ph FROM activity WHERE UID='$uid' AND timestampMs>=$start AND timestampMs<=$end GROUP BY type,ph ORDER BY type_counter DESC, type) AS Y GROUP BY type");
// $result4 = $conn->query("SELECT pd,type_counter FROM (SELECT type, COUNT(*) as type_counter, FROM_UNIXTIME(timestampMs/1000, '%W') as pd FROM activity WHERE UID='$uid' AND timestampMs>=$start AND timestampMs<=$end GROUP BY type,pd ORDER BY type_counter DESC, type) AS Y GROUP BY type");
// var_dump($selected);
$selected = implode("','",$selected);
// var_dump($selected);
// echo("SELECT d.latitudeE7, d.longitudeE7, COUNT(*) AS heat_count
//                           FROM data d 
//                           INNER JOIN activity a ON a.fileID = d.fileID AND a.location_id = d.location_id
//                           WHERE a.type IN ('$selected') AND d.timestampMs>=$start AND d.timestampMs<=$end GROUP BY d.latitudeE7, d.longitudeE7");
$result5 =  $conn->query("SELECT d.latitudeE7, d.longitudeE7, COUNT(*) AS heat_count
                          FROM data d 
                          INNER JOIN activity a ON a.fileID = d.fileID AND a.location_id = d.location_id
                          WHERE a.type IN ('$selected') AND d.timestampMs>=$start AND d.timestampMs<=$end GROUP BY d.latitudeE7, d.longitudeE7")or die(mysqli_error($conn));

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

// while($row=mysqli_fetch_assoc($result2)) {
//     array_push($years, $row['time']);
// }
// while($row1=mysqli_fetch_assoc($result1)) {
//     array_push($sum, $row1['type_counter']);
//     array_push($types, $row1['type']);
// }
// while($row2=mysqli_fetch_assoc($result3)) {
//     array_push($peak_h, $row2['ph']);
//    array_push($sum_ph, $row2['type_counter']);
   
// }
// while($row3=mysqli_fetch_assoc($result4)) {
//     array_push($peak_d, $row3['pd']);
//     array_push($sum_pd, $row3['type_counter']);
   
// }
while($row4=mysqli_fetch_assoc($result5)) {
    array_push($lon, ['lon'=>$row4['longitudeE7']/ 10000000.0, 'lat' => $row4['latitudeE7']/ 10000000.0, 'heat_count' => $row4['heat_count']]);
    // array_push($lat, $row4['latitudeE7']);
    // array_push($heat_count, $row4['heat_count']);
}

$admin_map = array('lon'=>$lon);
echo json_encode($admin_map);
?>			