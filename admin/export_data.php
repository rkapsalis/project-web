<?php
session_start();
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: content-type,  x-filename,cache-control");
header("Access-Control-Allow-Methods", "GET,HEAD,OPTIONS,POST,PUT");

ini_set('memory_limit', '-1');
ini_set('file_uploads'   , '1');
ini_set('max_input_vars', '10000');
//ini_set('post_max_size', '6000M');
ini_set('max_input_time', '2592000');
ini_set('upload_max_filesize', '6000M');

// set_time_limit(900);
// Resume the previous session
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
$file_type = $_POST["file_type"];

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
$start = strtotime(date("Y-m-w h:i A", strtotime($date_start)))*1000000;
$end = strtotime(date("Y-m-31", strtotime($date_end)))*1000;

$hour_s = "$hoursince:$minutessince $pm_am_s";
$hour_u = "$houruntil:$minutesuntil $pm_am_u";
$hoursince = date("H:i", strtotime($hour_s));
$houruntil = date("H:i", strtotime($hour_u));
$selected = implode("','",$selected);

// $result =  $conn->query("SELECT d.latitudeE7, d.longitudeE7, d.heading, a.type, a.confidence, a.timestampMs as a_timestampMs, d.verticalAccuracy, d.velocity, d.accuracy, d.altitude, d.timestampMs, d.UID
//                           FROM data d 
//                           INNER JOIN activity a ON a.fileID = d.fileID AND a.location_id = d.location_id
//                           WHERE a.type IN ('$selected') AND d.timestampMs>=$start AND d.timestampMs<=$end")or die(mysqli_error($conn));
$result =  $conn->query("SELECT d.latitudeE7, d.longitudeE7, d.heading, a.type, a.confidence, a.timestampMs as a_timestampMs, d.verticalAccuracy, d.velocity, d.accuracy, d.altitude, d.timestampMs, d.UID
                          FROM data d 
                          INNER JOIN activity a ON a.fileID = d.fileID AND a.location_id = d.location_id
                          WHERE a.type IN ('$selected') AND WEEKDAY(from_unixtime(d.timestampMs/1000)) BETWEEN $daysince AND $dayuntil AND FROM_UNIXTIME(d.timestampMs/1000,'%H:%i')
                          BETWEEN '$hoursince' AND '$houruntil' AND MONTH(FROM_UNIXTIME(d.timestampMs/1000)) BETWEEN $month_s AND $month_u AND YEAR(FROM_UNIXTIME(d.timestampMs/1000)) BETWEEN $year_s AND $year_u")or die(mysqli_error($conn));

 $latitudeE7 =[];
 $longitudeE7 = [];
 $velocity = [];
 $accuracy = [];
 $verticalAccuracy = [];
 $altitude = [];
 $timestampMs = [];
 $a_timestampMs = [];
 $heading = [];
 $type = [];
 $confidence = [];
 $UID = [];
 $data = [];

while($row=mysqli_fetch_assoc($result)) {
    array_push($latitudeE7, $row['latitudeE7']);    
    array_push($longitudeE7, $row['longitudeE7']);
    array_push($velocity, $row['velocity']);
    array_push($accuracy, $row['accuracy']);
    array_push($verticalAccuracy, $row['verticalAccuracy']); 
    array_push($altitude, $row['altitude']);
    array_push($timestampMs, $row['timestampMs']);
    array_push($a_timestampMs, $row['a_timestampMs']);
    array_push($heading, $row['heading']);
    array_push($type, $row['type']);
    array_push($confidence, $row['confidence']);
    array_push($UID, $row['UID']);
    array_push($data,['latitudeE7' => $row['latitudeE7'],'longitudeE7'=> $row['longitudeE7'],'velocity'=> $row['velocity'],'accuracy' => $row['accuracy'],'verticalAccuracy'=> $row['verticalAccuracy'], 'altitude'=>$row['altitude'],'timestampMs'=> $row['timestampMs'],'a_timestampMs'=> $row['a_timestampMs'],'heading'=>$row['heading'],'type'=> $row['type'],'confidence'=> $row['confidence'], 'UID'=> $row['UID'] ]);
}

if($file_type=="JSON"){
   $fp = fopen('data.json', 'w');
   fwrite($fp, json_encode($data,JSON_PRETTY_PRINT));
   fclose($fp);
  
}

if($file_type=="CSV"){
	$pathToGenerate='data.csv';    // your path and file name
    $header=FALSE;
    $createFile=fopen($pathToGenerate,'w+');
    foreach ($data as $row)
    {   if (!$header)
        {   fputcsv($createFile,array_keys($row));
            $header=TRUE;
        }
        fputcsv($createFile,$row);   // write the data for all rows
    }
    fclose($createFile);
}

if($file_type=="XML"){
	
	//Creates XML string and XML document using the DOM 
	$domxml = new DOMDocument('1.0');
	$root = $domxml->appendChild($domxml->createElement("Locations"));
    foreach($data as $user){
        if(!empty($user)){
            $loc = $root->appendChild($domxml->createElement('Location'));
            foreach($user as $key=>$val){
                $loc->appendChild($domxml->createElement($key, $val));
            }
        }
    }

	
	$domxml->preserveWhiteSpace = false; //remove redundant white space
	$domxml->formatOutput = true; //make the output pretty
	
	$data = $domxml->saveXML();
	$domxml->save('data.xml'); //save as file
}
?>