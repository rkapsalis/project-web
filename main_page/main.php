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
			<link rel="stylesheet" href='https://netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css'>
			<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
			<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css" integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz" crossorigin="anonymous">
		</head>
		<body>
			<div class="login-wrap">
				<div class="left">
					<img src="yellow_low res.png" style="margin-top:0" height="45" width="44">
					<h1 style="font-family:Segoe UI; width:200px; display:inline; bottom:10px;position: relative;"> Patras Gazer  </h1>
					<p style="font-size: 15px;"> Crowdsourcing app, using <br> Google Maps location history data. </p>
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
									<span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>
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
									<!-- <a href="#forgot">Forgot Password?</a> -->
									<label for="tab-2" style="cursor:pointer">Forgot Password?</a>
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
				<ul class="social">
					<p style="font: 600 16px/18px 'Open Sans',sans-serif !important;">Romanos Kapsalis &copy 2020 </p>
					<li><a href="https://www.linkedin.com/in/romanos-kapsalis/" style="padding: 0px 0px 0px 68px" target="_blank"><i class="icon-linkedin"></i></a></li>
					<li><a href="https://github.com/rkapsalis" target="_blank"><i class="icon-github"></i></a></li>
				</ul>
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
			
				if (username == "" || pass == "" || email == "" || first == "" || last == "" || password2 == "") {
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
					window.location.href = "/main.php"
					} else {
					
					$('.confirmation-popup-container').toggleClass('is-visible');
					$('#error-msg').append(response);
					$('.fa-close').click(function () { //cancel and close button
						$(this).parents('.confirmation-popup-container').fadeOut(500, function () {
							$(this).removeClass('is-visible');
							$(this).css("display", "");
						});
					});
					}
									
					}
					});
					}
					});
					
					
					});
					$(".toggle-password").click(function() {
					$(this).toggleClass("fa-eye fa-eye-slash");
					var input = $("#pass");
					if (input.attr("type") == "password") {
					input.attr("type", "text");
					input.attr("data-type", "text");
					} else {
					input.attr("type", "password");
					input.attr("data-type", "text");
					}
				});
			</script>
		</body>
	</html>
	<?php
	unset($_SESSION["error"]);
	?>