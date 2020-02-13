<?php
require_once 'C:/Users/Ρωμανός/vendor/autoload.php';
include_once 'JsonMachine.php';

ini_set('memory_limit', '-1');
set_time_limit(900);
use Brick\Db\Bulk\BulkInserter;
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
		    $arr[$count]["timestampMs"] = $timestampMs;
		    $arr[$count]["latitudeE7"] = $latitudeE7;
		    $arr[$count]["longitudeE7"] = $longitudeE7;
		    $arr[$count]["accuracy"] = $accuracy;
	            $count++;
	              	if (isset($value["activity"])) {
			 
			   foreach ($value["activity"] as $valac ){
										
				  $activity = $value["activity"][$counter2];
				  $activity_timestamp = $activity["timestampMs"];
				  $c=count($activity["activity"]);
									   
				  if($c>1 ){
				     foreach ($valac["activity"] as $vala ){
					
					     $activity_type = $activity["activity"][$counter1]["type"];
					     $activity_confidence = $activity["activity"][$counter1]["confidence"];
					     $arr_ac[$counter]["timestampMs"] = $activity_timestamp;
			                     $arr_ac[$counter][$counter1]["type"] = $activity_type;
			                     $arr_ac[$counter][$counter1]["confidence"] = $activity_confidence;
			                     $arr_ac[$counter][$counter1]["count"] = $count;
					     $counter1++;
				     }					   
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

$inserter = new BulkInserter($pdo, 'data', ['timestampMs', 'latitudeE7', 'longitudeE7', 'accuracy']);
$pdo->beginTransaction();
foreach ($arr as $value){
	$inserter->queue( $value['timestampMs'] , $value['latitudeE7'] , $value['longitudeE7'] , $value['accuracy'] );   
}

$inserter->flush();
$pdo->commit();

?>

