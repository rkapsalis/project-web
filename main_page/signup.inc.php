<?php
header("Access-Control-Allow-Origin", "http://127.0.0.1:80");


if(isset($_POST["pwd_repeat"])){
    require_once 'db_handler.inc.php';
    
    $username = $_POST["usr"];
    $password = $_POST["pwd"];
    $passwordr = $_POST["pwd_repeat"];
    $email = $_POST["mail"];
	$name =  $_POST["name"];
	$surname =  $_POST["surname"];
    
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)){ //check if email is valid
         echo "E-mail not valid. Please try again!";       
        exit();
    }
    elseif(strlen($password)<8 ){ //at least 8 characters
        echo "Password must contain at least 8 characters. Please try again!";
        exit();
    }
    elseif (!preg_match("/[A-Z]/", $password)) { //at least one capital letter        
        echo "Password must contain at least one capital letter. Please try again!";
        exit();
    }
    elseif (!preg_match("/\W/", $password)) { //at least one special character        
        echo "Password must contain at least one special character. Please try again!";
        exit();
    }
    elseif (!preg_match("/\d/", $password)) { //at least one digit       
        echo "Password must contain at least one digit. Please try again!";
        exit();
    }   
    elseif ($password !== $passwordr){ //password and repeat password must be the same
        echo "Passwords do not match. Please try again!";      
        exit();
    }
    else{

        //2-way encryption
        $EncryptedEmail = $email;
        $encryptionMethod = "AES-256-CBC";  
        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc')); //initialization vector
        $key = $password;
        $userID = openssl_encrypt($EncryptedEmail, $encryptionMethod, $key, 0, $iv);
        
        //password hashing
        $hashedPass = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO user(userID, username, password, firstname, lastname, email) VALUES (?,?,?,?,?,?)";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt,$sql)){
            //header("Location:.../main.html?error=sqlerror");			
			echo("Error description: " . mysqli_error($conn));
            exit();
        }
        else{
            mysqli_stmt_bind_param($stmt,"ssssss",$userID,$username,$hashedPass,$name,$surname,$email);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);
            //header("Location:.../main.html?signup=success");
			echo 1; 
            exit();
			
        }
               
    }
   
    mysqli_stmt_close($stmt);
    mysqli_close($conn);

}
?>