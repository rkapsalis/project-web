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

$result_a = $conn->query("SELECT type,COUNT(*) as type_counter FROM activity GROUP BY type"); //per activity type
$result_b = $conn->query("SELECT user.username as UID,COUNT(*) as user_counter FROM data INNER JOIN user ON user.userID = data.UID GROUP BY data.UID"); 
$result_c = $conn->query("SELECT COUNT(*) as month_counter, FROM_UNIXTIME(timestampMs/1000, '%M') as month FROM data GROUP BY month ORDER BY FIELD(month, 'January', 'February', 'March', 'April', 'May', 'June', 'July','August','September','October','November','December')"); //per month
$result_d = $conn->query("SELECT COUNT(*) as day_counter, FROM_UNIXTIME(timestampMs/1000, '%W') as day FROM data GROUP BY day ORDER BY FIELD(day, 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday')"); //per day
$result_e = $conn->query("SELECT COUNT(*) as hour_counter, HOUR(FROM_UNIXTIME(timestampMs/1000)) as hour FROM data GROUP BY hour ORDER BY hour"); //per hour
$result_f = $conn->query("SELECT COUNT(*) as year_counter, FROM_UNIXTIME(timestampMs/1000, '%Y') as year FROM data GROUP BY year ORDER BY year"); //per year


$typeArray = array();
$userArray = array();
$monthArray = array();
$dayArray = array();
$hourArray = array();
$yearArray = array();

while($row1 = mysqli_fetch_assoc($result_a)){

   $typeArray[$row1['type']] = $row1['type_counter'];
}

while($row2 = mysqli_fetch_assoc($result_b)){

   $userArray[$row2['UID']] = $row2['user_counter'];
}

while($row3 = mysqli_fetch_assoc($result_c)){

   $monthArray[$row3['month']] = $row3['month_counter'];
}

while($row4 = mysqli_fetch_assoc($result_d)){

   $dayArray[$row4['day']] = $row4['day_counter'];
}

while($row5 = mysqli_fetch_assoc($result_e)){

   $hourArray[$row5['hour']] = $row5['hour_counter'];
}

while($row6 = mysqli_fetch_assoc($result_f)){

   $yearArray[$row6['year']] = $row6['year_counter'];
}

$db_stats = array('name'=>$u_name,'type'=> $typeArray,'user'=>$userArray, 'month'=>$monthArray,'day'=>$dayArray, 'hour'=>$hourArray, 'year'=>$yearArray);
echo json_encode($db_stats);
?>