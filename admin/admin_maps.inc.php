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
ini_set('memory_limit', '-1');
// If the user is not logged in redirect to the login page
if (!isset($_SESSION['rememberMe'])) {
	header('Location: main.php');
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
    $daysince = "0";
}
if($dayuntil == "ALL"){
    $dayuntil = "6";
}
if($hoursince == "ALL"){
    $hoursince = "00";
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

$hour_s = "$hoursince:$minutessince $pm_am_s";
$hour_u = "$houruntil:$minutesuntil $pm_am_u";
$hoursince = date("H:i", strtotime($hour_s));
$houruntil = date("H:i", strtotime($hour_u));
$selected = implode("','",$selected);

$temp = "";
if($year_s>$year_u){
  $temp = $year_s;
  $year_s = $year_u;
  $year_u = $temp;
}
$query1 = "SELECT d.latitudeE7, d.longitudeE7, COUNT(*) AS heat_count
                          FROM data d 
                          INNER JOIN activity a ON a.fileID = d.fileID AND a.location_id = d.location_id
                          WHERE a.type IN ('$selected')";
// Days        
if($daysince > $dayuntil){
    $query2 = "AND ( NOT (WEEKDAY(from_unixtime(d.timestampMs/1000)) < $daysince AND WEEKDAY(from_unixtime(d.timestampMs/1000)) > $dayuntil) ) ";               
}            
else{
    $query2 = " AND WEEKDAY(from_unixtime(d.timestampMs/1000)) BETWEEN $daysince AND $dayuntil ";               
}  

// Months        
if($month_s > $month_u){
    $query3 = " AND ( NOT (MONTH(FROM_UNIXTIME(d.timestampMs/1000)) < $month_s AND MONTH(FROM_UNIXTIME(d.timestampMs/1000)) > $month_u) ) ";                
}            
else{
    $query3 = "AND MONTH(FROM_UNIXTIME(d.timestampMs/1000)) BETWEEN $month_s AND $month_u";                
}

// Hours and minutes      
if($hoursince > $houruntil){
    $query4 = " AND (NOT (FROM_UNIXTIME(d.timestampMs/1000,'%H:%i') < '$hoursince' AND FROM_UNIXTIME(d.timestampMs/1000,'%H:%i') > '$houruntil')) ";           
}           
else{
    $query4 = " AND FROM_UNIXTIME(d.timestampMs/1000,'%H:%i') BETWEEN '$hoursince' AND '$houruntil' ";                
}

$query5 = "AND YEAR(FROM_UNIXTIME(d.timestampMs/1000)) BETWEEN $year_s AND $year_u GROUP BY d.latitudeE7, d.longitudeE7";

$query = $query1.$query2.$query3.$query4.$query5;
$result5 =  $conn->query($query);

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