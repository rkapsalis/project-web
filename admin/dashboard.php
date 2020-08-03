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
$result_a = $conn->query("SELECT type,COUNT(*) as type_counter FROM activity GROUP BY type");
$result_b = $conn->query("SELECT UID,COUNT(*) as user_counter FROM data GROUP BY UID");
$result_c = $conn->query("SELECT COUNT(*) as month_counter, FROM_UNIXTIME(timestampMs/1000, '%M') as month FROM data GROUP BY month");
$result_d = $conn->query("SELECT COUNT(*) as day_counter, FROM_UNIXTIME(timestampMs/1000, '%W') as day FROM data GROUP BY day");
$result_e = $conn->query("SELECT COUNT(*) as hour_counter, FROM_UNIXTIME(timestampMs/1000, '%h%p') as hour FROM data GROUP BY hour");
$result_f = $conn->query("SELECT COUNT(*) as year_counter, FROM_UNIXTIME(timestampMs/1000, '%Y') as year FROM data GROUP BY year");


$typeArray = array();
$userArray = array();
$monthArray = array();
$dayArray = array();
$hourArray = array();
$yearArray = array();

while($row1 = mysqli_fetch_assoc($result_a)){

   $typeArray[$row1['type']] = $row1['type_counter'];
}

foreach($typeArray as $k => $id){
    echo $k."=>".$id;
}

while($row2 = mysqli_fetch_assoc($result_b)){

   $userArray[$row2['UID']] = $row2['user_counter'];
}

foreach($userArray as $k => $id){
    echo $k."=>".$id;
}

while($row3 = mysqli_fetch_assoc($result_c)){

   $monthArray[$row3['month']] = $row3['month_counter'];
}

foreach($monthArray as $k => $id){
    echo $k."=>".$id;
}

while($row4 = mysqli_fetch_assoc($result_d)){

   $dayArray[$row1['day']] = $row4['day_counter'];
}

foreach($dayArray as $k => $id){
    echo $k."=>".$id;
}

while($row5 = mysqli_fetch_assoc($result_e)){

   $hourArray[$row5['hour']] = $row5['hour_counter'];
}

foreach($hourArray as $k => $id){
    echo $k."=>".$id;
}

while($row6 = mysqli_fetch_assoc($result_f)){

   $yearArray[$row6['year']] = $row6['year_counter'];
}

foreach($yearArray as $k => $id){
    echo $k."=>".$id;
}
$db_stats = array('type'=> $typeArray,'user'=>$userArray, 'month'=>$monthArray,'day'=>$dayArray, 'hour'=>$hourArray, 'year'=>$yearArray);
echo json_encode($db_stats);
?>