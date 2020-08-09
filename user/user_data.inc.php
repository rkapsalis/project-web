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
$month = date("(F)", date("m"));
$year = date("Y");
//print_r($_SESSION);

//eco-score
function eco_score($uid, $month, $year){
	require 'db_handler.inc.php';
	$query_date = "$year-$month-01";
	$start = strtotime(date("Y-m-01 00:00:00", strtotime($query_date)))*1000;
	$end = strtotime(date("Y-m-t 23:59:59", strtotime($query_date)))*1000;	
	$result = $conn->query("SELECT * FROM activity WHERE UID='$uid' AND timestampMs>=$start AND timestampMs<=$end");		
	// var_dump($result);
	if ($result) {
	
		$body = ["ON_BICYCLE", "ON_FOOT", "RUNNING", "WALKING"]; //δραστηριότητα σώματος		
		$results = 0;
		$body_activities = 0;		
		
		while($row=mysqli_fetch_assoc($result)) {
			
			$activity = $row["type"];
		    if(($activity != "NULL") && ($activity != "UNKNOWN")){
			  if (in_array($activity, $body)) {
				$body_activities++; //σύνολο δραστηριοτήτων σώματος
			  } 
			  $results++; //σύνολο όλων των δραστηριοτήτων μετακίνησης
			}
		}
	    $result->close();
	    //υπολογισμός eco-score
		if ($body_activities <= 0 and $results <= 0) {
		   $ecoscore = 0;
	    }
		else{
	       $ecoscore = (int)(100* $body_activities / $results);
		}
	}
	else{
		$ecoscore = "N/A";
	}
	return $ecoscore;
}
// $eco_score = eco_score($uid, $month, $year); -------------τρεχων μηνας
require 'db_handler.inc.php';


//η περίοδος που καλύπτουν οι εγγραφές του χρήστη

$min_date = $conn->query("SELECT MIN(timestampMs) FROM data WHERE UID='$uid'");
$max_date = $conn->query("SELECT MAX((timestampMs)) FROM data WHERE UID='$uid'");
//var_dump(mysqli_fetch_row($min_date));
// echo("SELECT MIN(timestampMs) FROM data WHERE UID='$uid'");
$min_date = mysqli_fetch_row($min_date);
$max_date = mysqli_fetch_row($max_date);
// var_dump($min_date[0]);
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
         



//η ημερομηνία τελευταίου upload που έκανε ο χρήστης

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



//data for chart

$ac_per_month = [];
for ($i = 1; $i <= 12; $i++) { 
    array_push($ac_per_month, eco_score($uid, $i, date("Y"))); 
}
//$ac_per_month = json_encode($ac_per_month);
 



//leaderboard

    $users_q = $conn->query("SELECT userid, firstname, lastname FROM user");
    $users = [];
    if ($users_q) {
	   while ($row = mysqli_fetch_assoc($users_q)) {
             array_push($users, [$row["userid"], $row["firstname"], $row["lastname"]]);
			 if ($row["userid"] == $uid){
				 $my_name =  $row["firstname"];
                 $my_surname = $row["lastname"];				 
			 }
       }
    }
	
	// Calculate the scores for all users
	$eco_scores = [];
				
	foreach ($users as $value) {
		$result = $conn->query("SELECT ecoScore AND updateTime FROM score WHERE userID='$value[0]'");
	    $row1 = mysqli_fetch_row($result);
        $score = $row1[0];
        $upload = $row1[1];
		$cur_date = date("Y-m-d H:i:s");					
		if (is_null($score) || (date('m',strtotime($upload)) != date('m'))){ 
			$user_score = eco_score($value[0], date("m"), date("Y"));
			array_push($eco_scores, [$user_score, $value[1], $value[2], $value[0]]);
			$score_ins = $conn->query("INSERT INTO score VALUES('$uid','$user_score','$cur_date') ON DUPLICATE KEY UPDATE ecoScore='$user_score', updateTime='$cur_date'"); //insert eco_score and insertion time
		}
		else{  //if eco_score of current month exists
  		     array_push($eco_scores, [$score, $value[1], $value[2], $value[0]]);
		}
	}
				
				//top 3 users
				$rank = [];
				$key = 0;
				$score_sort = $conn->query("SELECT user.firstname, user.lastname, score.ecoScore FROM user INNER JOIN score ON user.userID=score.userID ORDER BY score.ecoScore DESC LIMIT 3"); 
				//$score_sort = $conn->query("SELECT * FROM score ORDER BY ecoScore DESC LIMIT 3");
				if($score_sort) {
                       while($row = mysqli_fetch_row($score_sort)){
                             
					         $name = $scores[$i][1];
					         $surname = mb_substr($scores[$i][2], 0, 1,'UTF8'); //get only the first character
					         $score = $scores[$i][0];					         
					         //array_push($rank, "$name $surname. $score%");
                             $rank[$key]['name'] = $name;
                             $rank[$key]['surname'] = $surname;
                             $rank[$key]['score'] = $score;
                             $rank[$key]['rank'] = $key;
							 $key++;
                       }
                }
				
				//my rank
				$my_rank = $conn->query("SELECT COUNT(*) AS rank FROM score WHERE ecoScore>=(SELECT ecoScore FROM score WHERE userID=$uid)");				
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