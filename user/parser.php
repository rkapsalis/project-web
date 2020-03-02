<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: content-type,  x-filename,cache-control");
header("Access-Control-Allow-Methods", "GET,HEAD,OPTIONS,POST,PUT");
require_once 'C:/Users/Ρωμανός/vendor/autoload.php';
include_once 'JsonMachine.php';

ini_set('memory_limit', '-1');
ini_set('file_uploads'   , '1');
ini_set('max_input_vars', '1000000');
ini_set('post_max_size', '6000M');
ini_set('upload_max_filesize', '6000M');

set_time_limit(900);
use Brick\Db\Bulk\BulkInserter;
if( isset($_POST['cens']) && isset($_SERVER['HTTP_X_FILENAME']) ){
     $rect = json_decode($_POST["cens"], true);
	 var_dump($rect);
}
else{
	die("error");
}
$fn = (isset($_SERVER['HTTP_X_FILENAME']) ? $_SERVER['HTTP_X_FILENAME'] : false);
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
$users = JsonMachine::fromFile('Ιστορικό_τοποθεσίας4.json','/locations');

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "web";

$pdo = new PDO('mysql:host=localhost;dbname=web', $username, $password);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

$array = array();
$arr = array();
$arr_ac = array();
$count = 0;
$count_ac = 0;
$counter = 0;
$counter1 = 0;
$counter2 = 0 ;
$c=0;
$activity_timestamp = "NULL";
$activity_type = "NULL";
$activity_confidence = "NULL";

function withinPatras($latitudeTo, $longitudeTo)
      {
       
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

foreach ($users as $row=>$value ) {
	           //if($row == 'timestampMs'){
	            $timestampMs = $value['timestampMs'];				
			  //}
			 // if($row == 'latitudeE7'){
		    $latitudeE7 = $value['latitudeE7'];
			 // }
			  //if($row == 'longitudeE7'){
	            $longitudeE7 = $value['longitudeE7'];
			  //}
		    $accuracy = $value['accuracy'];
	if(withinPatras($latitudeE7 / 10000000.0, $longitudeE7 / 10000000.0)<=10000){
		    $arr[$count]["timestampMs"] = $timestampMs;
		    $arr[$count]["latitudeE7"] = $latitudeE7;
		    $arr[$count]["longitudeE7"] = $longitudeE7;
		    $arr[$count]["accuracy"] = $accuracy;
		    if (isset($arr[$count]["altitude"])) { $altitude = $arr[$count]["altitude"]; }
		    if (isset($arr[$count]["verticalAccuracy"])) { $verticalAccuracy = $arr[$count]["verticalAccuracy"]; }
		    if (isset($arr[$count]["velocity"])) { $velocity = $arr[$count]["velocity"]; }
	            if (isset($arr[$count]["heading"])) { $heading = $arr[$count]["heading"]; }
	            $count++;
	              	if (isset($value["activity"])) {
			 
			   foreach ($value["activity"] as $valac ){
										
				  $activity = $value["activity"][$counter2];
				  $activity_timestamp = $activity["timestampMs"];
				  $c=count($activity["activity"]);
									   
				  if($c>1 ){
					  $temp_count = $counter;
				     foreach ($valac["activity"] as $vala ){
					
					   $activity_type = $activity["activity"][$counter1]["type"];
					   $activity_confidence = $activity["activity"][$counter1]["confidence"];
					   $arr_ac[$temp_count]["timestampMs"] = $activity_timestamp;
					   $arr_ac[ $temp_count ]["nested"] = "yes";
			                   $arr_ac[$temp_count]["type"] = $activity_type;
			                   $arr_ac[$temp_count]["confidence"] = $activity_confidence;
			                   $arr_ac[$temp_count]["count"] = $count;
					   $arr_ac[$temp_count]["count_arr"] = $counter2;
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
									  									   
				}
					$counter1 = 0;
					$counter++;									
					$counter2++;
			}
				$counter2 = 0;
		}	
	 
	}
}

$inserter = new BulkInserter($pdo, 'data', ['timestampMs', 'latitudeE7', 'longitudeE7', 'accuracy']);
$pdo->beginTransaction();
foreach ($arr as $value){
	$inserter->queue( $value['timestampMs'] , $value['latitudeE7'] , $value['longitudeE7'] , $value['accuracy'] );   
}
foreach ($arr_ac as $value_ac){			 
	$inserter2->queue( $value_ac['timestampMs'] , $value_ac['type'] , $value_ac['confidence'] , $value_ac['count'] , $value_ac['count_arr']);
}
$inserter->flush();
$inserter2->flush();
$pdo->commit();

?>

