<?php
session_start();
?>
<html lang="en" dir="ltr">
<head>
<meta charset="utf-8">
	<link rel="icon"
		type="image/png"
		href="yellow_high res.png">
 <title>Patras Gazer</title>
 <meta name="viewport" content="width=device-width, initial-scale=1">
 <link rel="stylesheet" href="main.css">
 <script src="https://code.jquery.com/jquery-3.4.1.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
<div class="login-wrap">
    <div class="left">
	
	<h1> <img src="yellow_low res.png" style="margin-top:0" height="35" width="44"> Patras Gazer.  </h1>
		<p>Google maps location history, data utilization system</p>
	</div>
	
	
	<div class="login-html">
	    
		<input id="tab-1" type="radio" name="tab" class="sign-in" checked><label for="tab-1" class="tab">Sign In</label>
		<input id="tab-2" type="radio" name="tab" class="sign-up"><label for="tab-2" class="tab">Sign Up</label>
		<div class="login-form">
			<div class="sign-in-htm">
			<form action="http://localhost/signin.inc.php" id="signin-form" method="post">
				<div class="group" >
					<label for="user" class="label">Username</label>
					<input id="user" name="usrn" type="text" class="input">
				</div>
				<div class="group">
					<label for="pass" class="label">Password</label>
					<input id="pass" name="pass" type="password" class="input" data-type="password">
				</div>
				<div class="group">
					<input id="check" type="checkbox" class="check" checked>
					<label for="check"><span class="icon"></span> Keep me Signed in</label>
				</div>
				<div class="group">
					<button type="submit" name="login" class="button" >Sign In</button>
				</div>
				<div class="hr"></div>
				<div class="foot-lnk">
					<a href="#forgot">Forgot Password?</a>
				</div>	
				<?php
                    if(isset($_SESSION["error"])){
                    	
                        $error = $_SESSION["error"];
                        echo "<span style=\"color:#ed0d09; top:20px; position: relative;\">$error</span>";
                    }
                ?>  			
				</form>
				
			</div>
			<div class="sign-up-htm">
			    <form action="" id="signup-form" method="post">
				<div class="group">
					<label for="user" class="label">Username</label>
					<input type="text" id="usr" name="usr" class="input">
				</div>
				<div class="group">
					<label for="pass" class="label">Password</label>
					<input type="password" id="pwd" name="pwd" class="input">
				</div>
				<div class="group">
					<label for="pass" class="label">Repeat Password</label>
					<input type="password" id="pwd1" name="pwd-repeat" class="input">
				</div>
				<div class="group">
					<label for="email" class="label">Email Address</label>
					<input type="email" id="mail" name="mail"  class="input">
				</div>
				<div class="group">
					<label for="first" class="label">Firstname</label>
					<input type="text" id="first" name="first"  class="input">
				</div>
				<div class="group">
					<label for="last" class="label">Lastname</label>
					<input type="text" id="last" name="last"  class="input">
				</div>
				<div class="group">
					
					<button type="submit" name="signup" class="button">Sign Up</button>
					
				</div>
				</form >
				<div class="hr"></div>
				<div class="foot-lnk">
					<label for="tab-1" style="cursor:pointer">Already Member?</a>
				</div>
				
			</div>
		</div>
	
	
</div>
</div>
	<div class="confirmation-popup" role="alert">
      <div class="confirmation-popup-container">
        <div class='dialog'><header>
          <h3>Oops! </h3><i class='fa fa-close'></i>
        </header>
        <div class="modal-center">
          <p id="error-msg"> </p>
          <hr>
          <i class="fa fa-info-circle"></i>
         <p style="width:200px; position:relative; display:inline-block">Password must contain: <br> </p>
           <p> 	 1. At least 8 characters. <br>
             2. At least one capital letter. <br>
             3. At least one special character (ex. #$*&@). <br>
             4. At least one digit.
          </p>         
        </div>       
        <!--  <a href="#0" class="cd-popup-close img-replace">Close</a> -->
      </div>
      </div> <!-- cd-popup-container -->
      </div> <!-- cd-popup -->
<div class="footer">
	     <p>Romanos Kapsalis &copy 2020 All rights reserved</p>
	</div>
</div>
<script type="text/javascript">
	  $(document).ready(function()
    {
	 $("#signup-form").submit(function signup_check() { //μολις κανει signup
	  event.preventDefault();
       var username = $("#usr").val();
       var pass = $("#pwd").val();
       var email = $("#mail").val();
	   var password2 = $("#pwd1").val();
       var first = $("#first").val();
	   var last = $("#last").val();
  
     if (username == "" || pass == "" || email == "" || first == "" || last == "") {
         alert("Please fill all the fields");
     } else {
         $.ajax({
             type: 'post',
             contentType: "application/x-www-form-urlencoded;charset=UTF-8",
             url: 'http://localhost/signup1.inc.php',
             data: {
                 mail: email,
                 usr: username,
                 pwd: pass,
				 pwd_repeat: password2,
				 name: first,
				 surname: last
             },
             success: function (response) {
                 if (response == 1) {  //επιστροφη στην αρχικη
                    alert("Successful signup!");
                   window.location.href = "/main.html"
                 } else {
                    // alert("Wrong Password or username.");
                     $('.confirmation-popup-container').toggleClass('is-visible');
                     $('#error-msg').append(response);
				      $('.fa-close').click(function () { //cancel and close button
				        $(this).parents('.confirmation-popup-container').fadeOut(500, function () {
				          $(this).remove();
				        });
				      });

                    
                 }
				 //alert(response);
             }
         });
     }
 });
  
 
  });
</script>
</body>

</html>
<?php
    unset($_SESSION["error"]);
?>