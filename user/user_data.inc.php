﻿<?php

session_start();
//require_once 'db_handler.inc.php';
// Resume the previous session
header("content-type: text/html; charset=utf8");  
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// If the user is not logged in redirect to the login page
if (!isset($_SESSION['rememberMe'])) {
	header('Location: main.html');
	session_destroy();
	exit();
}
$uid = $_SESSION['id'];
$u_name = $_SESSION['name'];
$month = date("(F)", date("m"));
$year = date("Y");
//print_r($_SESSION);
require 'db_handler.inc.php';
 
//-------------------------------------υπολογισμός eco-score---------------------------------------------
function eco_score($uid, $month, $year){
	require 'db_handler.inc.php';
	$query_date = "$year-$month-01";
	$start = strtotime(date("Y-m-01 00:00:00", strtotime($query_date)))*1000;
	$end = strtotime(date("Y-m-t 23:59:59", strtotime($query_date)))*1000;	
	$result = $conn->query("SELECT * FROM activity WHERE UID='$uid' AND type='user' AND timestampMs>=$start AND timestampMs<=$end");		
	
	if ($result) {
	
		$body = ["ON_BICYCLE", "ON_FOOT", "RUNNING", "WALKING"]; //δραστηριότητα σώματος		
		$results = 0;
		$body_activities = 0;		
		
		while($row=mysqli_fetch_assoc($result)) {
			
			$activity = $row["type"];
		    if(($activity != "NULL") && ($activity != "UNKNOWN") && ($activity != "TILTING")){
			  if (in_array($activity, $body)) {
				$body_activities++; //σύνολο δραστηριοτήτων σώματος
			  } 
			  $results++; //σύνολο όλων των δραστηριοτήτων μετακίνησης
			}
		}
	    $result->close();
	    //υπολογισμός eco-score
		if ($body_activities <= 0 OR $results <= 0) {
		   $ecoscore = 0;
		  
	    }
		else{
	       $ecoscore = (int)(100* $body_activities / $results);
		}
	}
	else{ //αν δεν υπάρχουν αποτελέσματα
		$ecoscore = "N/A";
	}
	
	return $ecoscore;
}
// $eco_score = eco_score($uid, $month, $year); -------------τρεχων μηνας
// require 'db_handler.inc.php';

//------------------------------------------------η περίοδος που καλύπτουν οι εγγραφές του χρήστη-------------------------------------------

$min_date = $conn->query("SELECT MIN(timestampMs) FROM data WHERE UID='$uid'");
$max_date = $conn->query("SELECT MAX((timestampMs)) FROM data WHERE UID='$uid'");

$min_date = mysqli_fetch_row($min_date);
$max_date = mysqli_fetch_row($max_date);

if($min_date != NULL){
   $min = date("j F Y", $min_date[0]/ 1000.0 );
}
else{
  $min = "N/A";
  
}
if($max_date != NULL){
   $max = date("j F Y", $max_date[0]/ 1000.0);
}
else{
   $max = "N/A";
}
// if ($min_date and $max_date) {
//------------------------------------------------------------my ecoscore(current month)----------------------------------------------------------
$month1 = date("n", $min_date[0]/ 1000.0);
$year1 = date("Y", $min_date[0]/ 1000.0);
$eco_score = eco_score($uid, $month1, $year1);					
//     if(is_null($min_date)){
//      	 // echo "<div class=/"pill__value/">Empty Set</div>";
//     	$min = "N/A";
// 	}
//     else{			  
// 		//print_r(mysqli_fetch_assoc($min_date));
       
// 		$min = date("j F Y", mysqli_fetch_assoc($min_date)["MIN((timestampMs))"]/ 1000.0 );
// 		$max = date("j F Y", mysqli_fetch_assoc($max_date)["MAX((timestampMs))"]/ 1000.0);
// 		//echo "<div class=/"pill__value/">$min - $max</div>";							
//         }
// }
// else{
// 	//echo "<div class=/"pill__value/">Error</div>";
// }

//----------------------------------------------------------------η ημερομηνία τελευταίου upload που έκανε ο χρήστης------------------------------------------------

$last_upload = $conn->query("SELECT MAX(uploadTime) FROM data WHERE UID='$uid'");
$last_upload = mysqli_fetch_row($last_upload);
if($last_upload != NULL){
   $last_up = date("j F Y, H:m:s", strtotime(($last_upload)[0]));
}
else{
  $last_up = "N/A";
  
}
// if ($last_upload) {					
//      if(is_null($last_upload)){
// 		//echo "<div class="pill__value">Empty Set</div>";
// 	}
//     else{			

// 		$last_up = date("j F Y, H:m:s", strtotime(mysqli_fetch_assoc($last_upload)["MAX(uploadTime)"]));
// 		//echo "<div class="pill__value">$last_up</div>";							
//     }
// }
// else{
// 	//echo "<div class="pill__value">Error</div>";
// }

//-----------------------------------------------------data for annual chart-----------------------------------------------------
for ($i = 1; $i <= 12; $i++) { //get last 12 months
    $months[] = date("Y-m", strtotime( date( 'Y-m-01' )." -$i months"));
}

$ac_per_month = [];
for ($i = 0; $i <= 11; $i++) { //get eco-score of last 12 months
    array_push($ac_per_month, eco_score($uid, $months[$i], date("Y"))); 
}

// require 'db_handler.inc.php';	

//----------------------------------------------leaderboard----------------------------------------------------

$users_q = $conn->query("SELECT userID, firstname, lastname FROM user WHERE type='user'");
$users = [];
if ($users_q) {
   while ($row = mysqli_fetch_assoc($users_q)) {
         array_push($users, [$row["userID"], $row["firstname"], $row["lastname"]]);
		 if ($row["userID"] == $uid){
			 $my_name =  $row["firstname"];
             $my_surname = $row["lastname"];				 
		 }
   }
}
	
//---------------------------------------------------------- Calculate the scores for all users--------------------------------------------------
$eco_scores = [];
			
foreach ($users as $value) { //for each user
	
	$result = $conn->query("SELECT ecoScore, updateTime FROM score WHERE userID='$value[0]'"); //select all eco-scores and update times from users		
      
    $score = "";
    $upload = "";
    $row1=mysqli_fetch_row($result);
    if($row1 != NULL) {
    	 $score = $row1[0];
         $upload = $row1[1];              
    }      
  
	$cur_date = date("Y-m-d H:i:s");					
	if (is_null($score) || (date('m',strtotime($upload)) != date('m'))){ //if the score isn't of the current month or is null
		$user_score = eco_score($value[0], date("m"), date("Y")); //get current month's eco-score
		array_push($eco_scores, [$user_score, $value[1], $value[2], $value[0]]);
		$score_ins = $conn->query("INSERT INTO score VALUES('$value[0]','$user_score','$cur_date') ON DUPLICATE KEY UPDATE ecoScore='$user_score', updateTime='$cur_date'"); //insert eco_score and insertion time
		  // var_dump($value);
		  // var_dump($user_score);
	}
	else{  //if eco_score of current month exists
		array_push($eco_scores, [$score, $value[1], $value[2], $value[0]]);
	}
}
// require 'db_handler.inc.php';			
//-----------------------------------------------------------top3 users-----------------------------------------------
$name = '';
$rank = [];
$key = 0;
$scores = $conn->query("SELECT user.firstname, user.lastname, score.ecoScore FROM user INNER JOIN score ON user.userID=score.userID ORDER BY score.ecoScore DESC LIMIT 3"); 

if($scores) {
       while($row3 = mysqli_fetch_assoc($scores)){
       	    
	         // $name = $row3[$key][1];
	         // $surname = mb_substr($row3[$key][2], 0, 1,'UTF-8'); //get only the first character
	         // $score = $row3[$key][0];		
	         $name = $row3['firstname'];
             $surname = mb_substr($row3['lastname'], 0, 1,'UTF-8');
             $score = $row3['ecoScore'];
	         //array_push($rank[$key], "$name $surname. $score%");              
             $rank[$key]['name'] = $name;                 
             $rank[$key]['surname'] = $surname;
             $rank[$key]['score'] = $score;
             $rank[$key]['rank'] = $key;
			 $key++;				          
            
       }
}    
		
//--------------------------------------------------------my rank--------------------------------------------------
$my_rank = $conn->query("SELECT COUNT(*) AS rank FROM score WHERE ecoScore>=(SELECT ecoScore FROM score WHERE userID='$uid')");				
$my_surname = mb_substr($my_surname, 0, 1,'UTF8'); //get only the first character			   				         
//array_push($rank, "$my_name $my_surname. $eco_score%");
$rank[3]['name'] = $my_name;
$rank[3]['surname'] = $my_surname;
$rank[3]['score'] = $eco_score;
if($my_rank == false){
	$my_rank = "N/A";
}
else{
   $rank[3]['rank'] = $my_rank;
}
$leaderboard = $rank;


	$user_data = array('uid'=> $uid,'name'=> $u_name,'month'=> $month1,'year'=> $year,'score'=> $eco_score,'min_date'=> $min,'max_date'=> $max,'upload'=> $last_up,'lead'=> $leaderboard,'months'=> $ac_per_month);	
	echo json_encode($user_data);
?>			