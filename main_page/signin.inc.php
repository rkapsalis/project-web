<?php
 session_start();
if (isset($_POST["login"])) {
    require_once 'db_handler.inc.php';

    $username = $_POST["usrn"];
    $password = $_POST["pass"];   
    $count=0;

     //τσεκαρουμε αν υπαρχει στην βαση
        $sql = "SELECT * FROM users WHERE username=?";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt,$sql)){
            header("Location:.../login.php?error=sqlerror");
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
                   
					session_regenerate_id();                   
					$_SESSION['name'] = $_POST['username'];
			        $_SESSION['id'] = $row['userID'];
					$_SESSION['rememberMe'] = true;
					
					if($row['type'] == 'admin'){
                        header("Location: admin.php"); 
                    } else {
                       header("Location: user_data.php"); 
                    }
                    $count++;                    
                    exit();                                       
                }
            }
                         
        } 
        else{
           die("wrong password or username");
        }
        if($count == 0){
           die("username not found");
        }
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
}  
}   
}


