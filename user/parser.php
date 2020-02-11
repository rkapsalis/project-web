<?php

include_once 'JsonMachine.php';
ini_set('memory_limit', '-1');
ini_set('xdebug.var_display_max_depth', '10');
ini_set('xdebug.var_display_max_children', '256');
ini_set('xdebug.var_display_max_data', '1024');
set_time_limit(500);
$jsonFile="ex1.json";
$users = JsonMachine::fromFile('ex1.json','/locations');
$j=0;
var_dump(count(array_keys((array)$users)));

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
			   var_dump($arr);
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
?>

