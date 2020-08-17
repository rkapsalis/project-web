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
$start = strtotime(date("Y-m-w h:i A", strtotime($date_start)))*1000;
$end = strtotime(date("Y-m-31", strtotime($date_end)))*1000;

$selected = implode("','",$selected);

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

while($row4=mysqli_fetch_assoc($result5)) {
    array_push($lon, ['lon'=>$row4['longitudeE7']/ 10000000.0, 'lat' => $row4['latitudeE7']/ 10000000.0, 'heat_count' => $row4['heat_count']]);  
}

$admin_map = array('lon'=>$lon);
echo json_encode($admin_map);
?>			