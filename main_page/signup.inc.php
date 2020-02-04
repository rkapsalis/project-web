<?php
header("Access-Control-Allow-Origin: *");
//if(isset($_POST["signup"])){
    require_once 'db_handler.inc.php';
   
    $username = $_POST["username"];
    $password = $_POST["password"];
    $passwordr = $_POST["passwordr"];
    $email = $_POST["email"];

    if(strlen($password)<8 ){
      header("Location:.../index.html?error=shortPassword");
	  
      exit();
    }
    elseif (!preg_match("/[A-Z]/", $password)) { //at least one capital letter
        header("Location:.../index.html?error=atLeastOneCapital");
        exit();
    }
    elseif (!preg_match("/\W/", $password)) { //at least one special character
        header("Location:.../index.html?error=atLeastOneSymbol");
        exit();
    }
    elseif (!preg_match("/\d/", $password)) { //at least one digit
        header("Location:.../index.html?error=atLeastOneDigit");
        exit();
    }
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)){ //δεν το ζηταει,ισως χρειαζεται
        header("Location:.../index.html?error=");
        exit();
    }
    elseif ($password !== $passwordr){
        header("Location:.../index.html?error=passwordsNotMatch");
        exit();
    }
    else{

        //2-way encryption
        $EncryptedEmail = $email;
        $encryptionMethod = "AES-256-CBC";  // υπαρχουν πολλες επιλογές εδώ, βλέπουμε
        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc')); //initialization vector
        $key = $password;
        $userID = openssl_encrypt($EncryptedEmail, $encryptionMethod, $key, 0, $iv);
        
        //password hashing
        $hashedPass = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO user(username, password,email) VALUES (?,?,?)";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt,$sql)){
			$sqlerror = mysqli_error($conn);
            header("Location:.../index.html?error=".$sqlerror."");
			echo '$hashedPass';
            exit();
        }
        else{
            mysqli_stmt_bind_param($stmt,"sss",$username,$hashedPass,$email);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);
            header("Location:.../index.html?signup=success");
            exit();
        }
        echo ("success") ;        
    }
    //θα βαλουμε να τσεκαρει και αν υπαρχει ηδη χρηστης στην βαση με το ιδιο username?
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
//}
