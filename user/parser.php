<?php
session_start();

// Resume the previous session
error_reporting(E_ALL);

// If the user is not logged in redirect to the login page
if (!isset($_SESSION['rememberMe'])) {
	header('Location: main.php');
	session_destroy();
	exit();
}
$uid = $_SESSION['id'];
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: content-type,  x-filename,cache-control");
header("Access-Control-Allow-Methods", "GET,HEAD,OPTIONS,POST,PUT");

require_once 'C:/Users/Ρωμανός/vendor/autoload.php';
include_once 'JsonMachine.php';

ini_set('memory_limit', '-1');
ini_set('file_uploads'   , '1');
ini_set('max_input_vars', '10000');
//ini_set('post_max_size', '6000M');
ini_set('max_input_time', '2592000');
ini_set('upload_max_filesize', '6000M');

//ini_set('xdebug.var_display_max_depth', '10');
//ini_set('xdebug.var_display_max_children', '256');
//ini_set('xdebug.var_display_max_data', '1024');
set_time_limit(900);
use Brick\Db\Bulk\BulkInserter;
//filename = $_POST['file'];
//print_r($_FILES);
 //$f = $_POST['fileselect'];
       // $filename = "data";
	   print_r($_POST);
var_dump(isset($_SERVER['HTTP_X_FILENAME']));
var_dump($_POST['cens']);
if( isset($_POST['cens']) && isset($_SERVER['HTTP_X_FILENAME']) ){
     $rect = json_decode($_POST["cens"], true);
	 var_dump($rect);
}
else{
	die("error");
}
$fn = (isset($_SERVER['HTTP_X_FILENAME']) ? $_SERVER['HTTP_X_FILENAME'] : false);
var_dump($fn);
var_dump($_FILES);

if ($fn) { //AJAX
    file_put_contents(
		$_SERVER['DOCUMENT_ROOT'].'/' . $fn,
		file_get_contents($_FILES['file']['name'])
	);
	echo "$fn uploaded";
}
else {

	// form submit
	$files = $_FILES['fileselect'];

	foreach ($files['error'] as $id => $err) {
		if ($err == UPLOAD_ERR_OK) {
			$fn = $files['name'][$id];
			move_uploaded_file(
				$files['tmp_name'][$id],
				$_SERVER['DOCUMENT_ROOT'].'/' . $fn
			);
			echo "<p>File $fn uploaded.</p>";
		}
	}

}
$filename = $_SERVER['DOCUMENT_ROOT'].'/' . $fn;
var_dump($filename);
//$in = fopen('php://input','r');
$users = JsonMachine::fromFile($filename,'/locations');

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "web";

$pdo = new PDO('mysql:host=localhost;dbname=web', $username, $password);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

$stmt =  $pdo->prepare("SELECT MAX(fileID) FROM data");
$stmt->execute(); 
$file_id = $stmt->fetchColumn();
 
$file_id++; 

function withinPatras($latitudeTo, $longitudeTo) {

        $earth_radius = 6371000;
	    $latitudeFrom = deg2rad(38.230462);
        $longitudeFrom = deg2rad(21.753150);
        $latitudeTo = deg2rad($latitudeTo);
        $longitudeTo = deg2rad($longitudeTo);

        $LatD = $latitudeTo - $latitudeFrom;
        $LonD = $longitudeTo - $longitudeFrom;

        $angle = 2 * asin(sqrt(pow(sin($LatD / 2), 2) + cos($latitudeFrom) * cos($latitudeTo) * pow(sin($LonD / 2), 2)));
        return $angle * $earth_radius;
}

$arr = array();
$arr_ac = array();
$count = 0; //location objects counter
$counter = 0; //activity objects counter
$counter1 = 0; //nested activity objects counter
$counter2 = 0 ; //main activity
$c=0;
$activity_timestamp = "NULL";
$activity_type = '0';
$activity_confidence = "NULL";


foreach ($users as $row=>$value ) { //iterate locations
   $altitude = NULL;
   $velocity = NULL;
   $heading = NULL;
   $verticalAccuracy = NULL;
   $excluded = false;

   //if($row == 'timestampMs'){
   $timestampMs = $value['timestampMs'];
   //}
   $latitudeE7 = $value['latitudeE7'];
   $longitudeE7 = $value['longitudeE7'];
   $accuracy = $value['accuracy'];


	foreach ($rect as &$value2) {  //exclude censored areas
		  $rect_reshaped = [$value2["p1"], $value2["p2"], $value2["p3"], $value2["p4"]];
		  $xs = [$rect_reshaped[0][0], $rect_reshaped[1][0], $rect_reshaped[2][0], $rect_reshaped[3][0]];
		  $ys = [$rect_reshaped[0][1], $rect_reshaped[1][1], $rect_reshaped[2][1], $rect_reshaped[3][1]];
		  if ($longitudeE7 > min($xs) && $latitudeE7 < max($xs) && $latitudeE7 > min($ys) && $latitudeE7 < max($ys)){ $excluded = true; }
		  var_dump($excluded);
		  if ($excluded) { break; }
	}

		if((withinPatras($latitudeE7 / 10000000.0, $longitudeE7 / 10000000.0)<=10000) && $excluded == false){ //check if it's inside Patras and censored areas
			   $arr[$count]["timestampMs"] = $timestampMs;
			   $arr[$count]["latitudeE7"] = $latitudeE7;
			   $arr[$count]["longitudeE7"] = $longitudeE7;
			   $arr[$count]["accuracy"] = $accuracy;
			   if (isset($value["altitude"])) { $altitude = $value["altitude"]; }
			   if (isset($value["verticalAccuracy"])) { $verticalAccuracy = $value["verticalAccuracy"]; }
			   if (isset($value["velocity"])) { $velocity = $value["velocity"]; }
			   if (isset($value["heading"])) { $heading = $value["heading"]; }
			   $arr[$count]["altitude"] = $altitude;
			   $arr[$count]["verticalAccuracy"] = $verticalAccuracy;
			   $arr[$count]["velocity"] = $velocity;
			   $arr[$count]["heading"] = $heading;
			     
			   $count++;
               $arr[$count-1]["location_id"] = $count;
							if (isset($value["activity"])) {

									//main activity iteration
								foreach ($value["activity"] as $valac ){

									   $activity = $value["activity"][$counter2];
									   $activity_timestamp = $activity["timestampMs"];
									   $c = count($activity["activity"]);

									 if($c>1 ){ //if activity has more than one objects
										   $temp_count = $counter;
									    foreach ($valac["activity"] as $vala ){ //nested activity

									       $activity_type = $activity["activity"][$counter1]["type"];
									       $activity_confidence = $activity["activity"][$counter1]["confidence"];
									       $arr_ac[$temp_count]["timestampMs"] = $activity_timestamp;
										   $arr_ac[$temp_count]["nested"] = "yes";
						                   $arr_ac[$temp_count]["type"] = $activity_type;
						                   $arr_ac[$temp_count]["confidence"] = $activity_confidence;
						                   $arr_ac[$temp_count]["count"] = $count;
										   $arr_ac[$temp_count]["count_arr"] = $counter2;
										   $arr_ac[$temp_count]["activity_id"] = $counter1;
									       $counter1++;
										   $temp_count++;
									   }
									    $counter = $temp_count;
									}
									else{

										$activity_type = $activity["activity"][0]["type"];
										$activity_confidence = $activity["activity"][0]["confidence"];
										$arr_ac[$counter]["timestampMs"] = $activity_timestamp;
										$arr_ac[$counter]["type"] = $activity_type;
							            $arr_ac[$counter]["confidence"] = $activity_confidence;
							            $arr_ac[$counter]["count"] = $count;
								      // $arr_ac[$counter]["count_arr"] = NULL;
									    // $arr_ac[$counter]["activity_id"] = 0;
									    $arr_ac[$counter]["count_arr"] = $counter2;
									    $arr_ac[$counter]["activity_id"] = 0;										  
									   

									}
									$counter1 = 0;
									$counter++;
									$counter2++;
									}
									 $counter2 = 0;
								}
	
	}
	else{
		//$count++;
	}
}

$inserter = new BulkInserter($pdo, 'data', ['UID','fileID','timestampMs', 'latitudeE7', 'longitudeE7', 'accuracy', 'altitude', 'verticalAccuracy', 'velocity', 'heading', 'uploadTime','location_id']);
$inserter2 = new BulkInserter($pdo, 'activity', ['UID','fileID','timestampMs', 'type', 'confidence', 'location_id', 'main_activity', 'activity_id', 'uploadTime']);
$pdo->beginTransaction();

foreach ($arr as $value){
	$inserter->queue( $uid, $file_id, $value['timestampMs'] , $value['latitudeE7'] , $value['longitudeE7'] , $value['accuracy'], $value['altitude'], $value['verticalAccuracy'], $value['velocity'], $value['heading'], date("Y-m-d H:i:s"), $value['location_id'] );
}
$inserter->flush();
foreach ($arr_ac as $value_ac){
	$inserter2->queue( $uid,$file_id,  $value_ac['timestampMs'] , $value_ac['type'] , $value_ac['confidence'] , $value_ac['count'] , $value_ac['count_arr'], $value_ac['activity_id'], date("Y-m-d H:i:s"));
}


$inserter2->flush();
$pdo->commit();
unlink($_SERVER['DOCUMENT_ROOT'].'/' . $fn);
?>
