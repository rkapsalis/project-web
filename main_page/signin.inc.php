<?php

header("Access-Control-Allow-Origin", "http://127.0.0.1");
header("Access-Control-Allow-Credentials: true");
header("Cache-Control: no-cache");
header("Pragma: no-cache");
header("Access-Control-Allow-Methods", "GET,HEAD,OPTIONS,POST,PUT");
header("Access-Control-Allow-Headers: content-type,  x-filename,cache-control, Origin");
ini_set('display_errors', 1);

session_start();


//if (isset($_POST["pass"])) {
    require_once 'db_handler.inc.php';

    $username = $_POST["usrn"];
    $password = $_POST["pass"];
    //$db_data = array();
    $count=0;
     
     //τσεκαρουμε αν υπαρχει στην βαση
        $sql = "SELECT * FROM user WHERE username=?";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt,$sql)){
            header("Location:.../main.php?error=sqlerror");
            exit();
        }
        mysqli_stmt_bind_param($stmt,"s",$username);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $rows = mysqli_num_rows($result);

        if ($rows > 0) {  //αν υπαρχει τετοιο username στην βαση
            while($row = mysqli_fetch_assoc($result)) {  //while ή if?
                $password_check = password_verify($password, $row['password']); 
                //$conn->query($sql) === TRUE
                if ($password_check == TRUE) {//τσεκαρουμε αν το χασαρισμενο password αντιστοιχει
                   
					//session_regenerate_id();                   
					$_SESSION['name'] = $row['username'];
			        $_SESSION['id'] = $row['userID'];
					$_SESSION['rememberMe'] = TRUE;
					
					if($row['type']== 'admin'){
                      header("Location: http://localhost/dashboard.php");                    			
                    } else {
                      header("Location: http://localhost/user_data.php"); 					   
                    }
                    $count++;                
                    exit();                                       
                }
            }      
             
        } 
        else{
            $error="Sorry, wrong password or username. Please try again.";
            $_SESSION["error"] = $error;
            header("location: http://localhost/main.php"); //send user back to the login page
           
        }
        if($count == 0){            
            $error1 ="Sorry, username not found. Please try again.";
            $_SESSION["error"] = $error1;
            header("location: http://localhost/main.php"); //send user back to the login page
           
        }
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
//}
?>
  
    



