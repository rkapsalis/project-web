<?php
session_start();
require('config.php');
// Resume the previous session
error_reporting(E_ALL);

// If the user is not logged in redirect to the login page
if (!isset($_SESSION['rememberMe'])) {
	header('Location: main.html');
	session_destroy();
	exit();
}
$uid = $_SESSION['id'];
$u_name = $_SESSION['username'];
$month = date("(F)", date("m"));
$year = date("Y");


//eco-score
function eco-score($uid, $month, $year){
	$query_date = "$year-$month-01";
	$start = strtotime(date("Y-m-01 00:00:00", strtotime($query_date)))*1000;
	$end = strtotime(date("Y-m-t 23:59:59", strtotime($query_date)))*1000;	
	$result = $con->query("SELECT * FROM activity WHERE userid='$uid' AND timestampMs>=$start AND timestampMs<=$end")		
	
	if ($result) {
	
		$body = ["ON_BICYCLE", "ON_FOOT", "RUNNING", "WALKING"];		
		$results = 0;
		$body_activities = 0;		
		
		while($row=mysqli_fetch_assoc($result)) {
			
			$activity = $row["type"];
		    if(($activity != "NULL") && ($activity != "UNKNOWN")){
			  if (in_array($activity, $body)) {
				$body_activities++;
			  } 
			  $results++;
			}
		}
	    $result->close();
		if ($body_activities <= 0 and $results <= 0) {
		   $eco_score = 0;
	    }
		else{
	       $eco_score = (int)(100* $body_activities / $results);
		}
	}
	return $eco_score;
}
$eco_score = eco-score($uid, $month, $year);



//η περίοδος που καλύπτουν οι εγγραφές του χρήστη

$min_date = $con->query("SELECT MIN(DATE(timestampMs)/1000.0) FROM data WHERE UID='$uid'");
$max_date = $con->query("SELECT MAX(DATE(timestampMs)/1000.0) FROM data WHERE UID='$uid'");
if ($min_date and $max_date) {
					
    if(is_null($min_date)){
     	 // echo "<div class=/"pill__value/">Empty Set</div>";
	}
    else{			  
		$min = date("j F Y", mysqli_fetch_assoc($min_date)["MIN(timestampMs)"] / 1000.0);
		$max = date("j F Y", mysqli_fetch_assoc($max_date)["MAX(timestampMs)"] / 1000.0);
		//echo "<div class=/"pill__value/">$min - $max</div>";							
        }
}
else{
	//echo "<div class=/"pill__value/">Error</div>";
}
         



//η ημερομηνία τελευταίου upload που έκανε ο χρήστης

$last_upload = $con->query("SELECT MAX(uploadTime) FROM data WHERE UID='$uid'");
if ($last_upload) {					
     if(is_null($last_upload)){
		//echo "<div class="pill__value">Empty Set</div>";
	}
    else{			
		$last_up = date("j F Y", mysqli_fetch_assoc($max_date)["MAX(timestampMs)"] / 1000.0);
		//echo "<div class="pill__value">$last_up</div>";							
    }
}
else{
	//echo "<div class="pill__value">Error</div>";
} 



//data for chart

$ac_per_month = [];
for ($i = 1; $i <= 12; $i++) { 
    array_push($ac_per_month, eco-score($uid, $i, date("Y"))); 
}
$ac_per_month = json_encode($ac_per_month);
 



//leaderboard

    $users_q = $con->query("SELECT userid, firstname, lastname FROM user");
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
		$result = $con->query("SELECT ecoScore AND updateTime FROM score WHERE userID='$value[0]'");
	    $row1 = mysql_fetch_row($result);
        $score = $row1[0];
        $upload = $row1[1];
		$cur_date = date("Y-m-d H:i:s");					
		if (is_null($score) || (date('m',strtotime($upload)) != date('m'))){ 
			$user_score = eco-score($value[0], date("m"), date("Y"));
			array_push($eco_scores, [$user_score, $value[1], $value[2], $value[0]]);
			$score_ins = $con->query("INSERT INTO score VALUES('$uid','$user_score','$cur_date')"); //insert eco_score and insertion time
		}
		else{  //if eco_score of current month exists
  		     array_push($eco_scores, [$score, $value[1], $value[2], $value[0]]);
		}
	}
				
				//top 3 users
				$rank = [];
				$key = 0;
				$score_sort = $con->query(SELECT user.firstname, user.lastname, score.ecoScore FROM user INNER JOIN score ON user.userID=score.userID ORDER BY score.ecoScore DESC LIMIT 3); 
				//$score_sort = $con->query("SELECT * FROM score ORDER BY ecoScore DESC LIMIT 3");
				if($score_sort) {
                       while($row = mysqli_fetch_row($score_sort)){
                             $key++;
					         $name = $scores[$i][1];
					         $surname = mb_substr($scores[$i][2], 0, 1,'UTF8'); //get only the first character
					         $score = $scores[$i][0];					         
					         //array_push($rank, "$name $surname. $score%");
                             $rank[$key]['name'] = $name;
                             $rank[$key]['surname'] = $surname;
                             $rank[$key]['score'] = $score;
                             $rank[$key]['rank'] = $key;
                       }
                }
				
				//my rank
				$my_rank = $con->query(SELECT COUNT(*) AS rank FROM score WHERE ecoScore>=(SELECT ecoScore FROM score WHERE userID=$uid));				
			    $my_surname = mb_substr($my_surname, 0, 1,'UTF8'); //get only the first character			   				         
				//array_push($rank, "$my_name $my_surname. $eco_score%");
				$rank[4]['name'] = $my_name;
                $rank[4]['surname'] = $my_surname;
                $rank[4]['score'] = $eco_score;
                $rank[4]['rank'] = $my_rank;
				$leaderboard = $rank;
		
	$result[] = array('uid'=> $uid,'name'=> $u_name,'month'=> $month,'year'=> $year,'score'=> $eco_score,'min_date'=> $min,'max_date'=> $date,'upload'=> $last_up,'lead'=> $leaderboard,'months'=> $ac_per_month);
	echo $result;
?>			
