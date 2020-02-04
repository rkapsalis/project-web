<?php
if (isset($_POST["login"])) {
    require_once 'db_handler.inc.php';

    $username = $_POST["usrn"];
    $password = $_POST["pass"];
    //$db_data = array();
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
                $password_check = password_verify($pwd, $row['password']); 
                //$conn->query($sql) === TRUE
                if ($password_check == TRUE) {//τσεκαρουμε αν το χασαρισμενο password αντιστοιχει
                    session_start();
                    $_SESSION[''] = $row[''];
                    $count++;
                    echo "success";
                    exit();                                       
                }
            }
             //echo json_encode($db_data);
             
        } 
        else{
            echo "fail";
        }
        if($count == 0){
            echo "fail";
        }
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
}
    /* else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    } /*
    
}    
    
}


