<?php

session_start();
//require_once 'db_handler.inc.php';
// Resume the previous session
// header("content-type: text/html; charset=utf8");  
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// If the user is not logged in redirect to the login page
if (!isset($_SESSION['id'])) {
	header("location:http://localhost/main.php");
	session_destroy();
	exit();
}

$uid = $_SESSION['id'];
$u_name = $_SESSION['name'];
$month = date("(F)", date("m"));
$year = date("Y");

require 'db_handler.inc.php';
 
//-------------------------------------υπολογισμός eco-score---------------------------------------------
function eco_score($uid, $month){
	require 'db_handler.inc.php';
	$query_date = "$month-01";
	$start = strtotime(date("Y-m-01 00:00:00", strtotime($query_date)))*1000;
	$end = strtotime(date("Y-m-t 23:59:59", strtotime($query_date)))*1000;	
	$result = $conn->query("SELECT * FROM activity WHERE UID='$uid'AND timestampMs>=$start AND timestampMs<=$end");
		
	if (mysqli_num_rows($result)!=0) {
	
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

// require 'db_handler.inc.php';

//------------------------------------------------η περίοδος που καλύπτουν οι εγγραφές του χρήστη-------------------------------------------
$min_date = $conn->query("SELECT MIN(timestampMs) FROM data WHERE UID='$uid'");
$max_date = $conn->query("SELECT MAX((timestampMs)) FROM data WHERE UID='$uid'");

$min_date = mysqli_fetch_row($min_date);
$max_date = mysqli_fetch_row($max_date);

if(!empty($min_date[0])){
   $min = date("j F Y", $min_date[0]/ 1000.0 );
}
else{
  $min = "N/A";
}

if(!empty($max_date[0]) ){
   $max = date("j F Y", $max_date[0]/ 1000.0);
}
else{
   $max = "N/A";
}

//------------------------------------------------------------my ecoscore(current month)----------------------------------------------------------
$month1 = date("n", $min_date[0]/ 1000.0);
$year1 = date("Y", $min_date[0]/ 1000.0);
$eco_score = eco_score($uid,date("Y-m")); //-------------------------------current month--------------------------------------

//$eco_score = eco_score($uid,'2015-09');  //-----------------------------random month--------------------------------------

//----------------------------------------------------------------η ημερομηνία τελευταίου upload που έκανε ο χρήστης------------------------------------------------
$last_upload = $conn->query("SELECT MAX(uploadTime) FROM data WHERE UID='$uid'");
$last_upload = mysqli_fetch_row($last_upload);
if($last_upload[0] != NULL){
   $last_up = date("j F Y, H:m:s", strtotime(($last_upload)[0]));
}
else{
  $last_up = "N/A";
  
}

$chart_months = [];
$months = [];
array_push($chart_months, date("F"));
array_push($months, date( 'Y-m' ));
//-----------------------------------------------------data for annual chart-----------------------------------------------------
for ($i = 1; $i <12; $i++) { //get last 12 months
    ///$months = date("Y-m", strtotime( date( 'Y-m-01' )." -$i months")); //οι τελευταιοι 12 μήνες
    array_push($months,date("Y-m", strtotime( date( 'Y-m-01' )." -$i months")));
    array_push($chart_months, date("F", strtotime( date( 'F-01' )." -$i months")));
}
$chart_months = array_reverse($chart_months);
$months = array_reverse($months);

$ac_per_month = [];
for ($i = 0; $i <= 11; $i++) { //get eco-score of last 12 months
    array_push($ac_per_month, eco_score($uid, $months[$i])); //το eco-score για τους τελευταίους 12 μήνες    
}

// require 'db_handler.inc.php';	

//----------------------------------------------leaderboard----------------------------------------------------
$users_q = $conn->query("SELECT userID, firstname, lastname FROM user WHERE type='user'");
$users = [];
if (mysqli_num_rows($users_q)!=0) {
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
	
	$result = $conn->query("SELECT ecoScore, updateTime FROM score WHERE userID='$value[0]' AND updateTime=NOW()"); //select all eco-scores and update times from users		
    
    $score = "";
    $upload = "";
    $row1=mysqli_fetch_row($result);
    
    if($row1 != NULL) {
    	 $score = $row1[0];
         $upload = $row1[1];                     
    }      
    
	$cur_date = date("Y-m-d H:i:s");					
	if (is_null($score) || (date('m',strtotime($upload)) != date('m'))){ //if the score isn't of the current month or is null
		$user_score = eco_score($value[0], date("Y-m")); //get current month's eco-score
	    //$user_score = eco_score($value[0], '2015-09');     //get random month's eco-score
	   
		array_push($eco_scores, [$user_score, $value[1], $value[2], $value[0]]);		
		$user_score= !empty($user_score) ? "'$user_score'" : "NULL";		
		$score_ins = $conn->query("INSERT INTO score VALUES('$value[0]',$user_score,'$cur_date') ON DUPLICATE KEY UPDATE ecoScore=$user_score, updateTime='$cur_date'"); //insert eco_score and insertion time
		
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
       	    
	         $name = $row3['firstname'];
             $surname = mb_substr($row3['lastname'], 0, 1,'UTF-8');//get only the first character of lastname
             if($row3['ecoScore']!=NULL){
             	 $score = $row3['ecoScore'];
             }
             else{
             	$score = "N/A";
             }
	                    
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
$my_rank=mysqli_fetch_row($my_rank);
$rank[3]['name'] = $my_name;
$rank[3]['surname'] = $my_surname;
$rank[3]['score'] = $eco_score;


if($my_rank[0]==NULL){
	$my_rank = "N/A";
}
else{
   $rank[3]['rank'] = $my_rank[0];
}
$leaderboard = $rank;

$user_data = array('uid'=> $uid,'name'=> $u_name,'month'=> $month1,'year'=> $year,'score'=> $eco_score,'min_date'=> $min,'max_date'=> $max,'upload'=> $last_up,'lead'=> $leaderboard,'months'=> $ac_per_month,'chart_months'=>$chart_months);	
echo json_encode($user_data);
?>			