<?php
session_start();
if (!isset($_SESSION['rememberMe'])) {
    header('Location: main.php');
    session_destroy();
    exit();
}
?>
<html>
	<meta charset="utf-8">
	<link rel="icon"
		type="image/png"
		href="yellow_high res.png">
		<title>Help | Patras Gazer</title>
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no"/>
		<link rel="stylesheet" href="usr.css">
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800">
		<link rel="stylesheet" href='https://netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css'>
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css" integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz" crossorigin="anonymous">
		<style> body{background-color: #1caff9;} .content p{color:black;} #gallery li{list-style-type: disc !important; list-style-position: inside;} .content p, li{font-size: 15px !important;} @media only screen and (max-width: 980px) {#subheader, #portfolio h2, #services h2{margin: 0 100px 5px !important; } .content{width:90% !important;}}</style>
		<body>
			<header>
				<section>
					<img src="yellow_low res.png" style="padding: 20px 0px 5px 0px" height="35" width="44">
					<a href="user_data.php" id="logo" target="_blank">Patras Gazer</a>
					<label for="toggle-1" class="toggle-menu"><ul><li></li> <li></li> <li></li></ul></label>
					<input type="checkbox" id="toggle-1">
					<nav >
						<ul>
							<li><a href="user_data.php"><i class="icon-user"></i>User Data</a></li>
							<li><a href="user_stats.php"><i class="fas fa-chart-bar"></i>Statistics</a></li>
							<li><a href="upload_file.php"><i class="fa fa-upload"></i>Upload</a></li>
							<li><a href="help.php"><i class="fa fa-question-circle"></i>Help</a></li>
							<li><a href="http://localhost/logout.php"><i class="fa fa-sign-out-alt" ></i>Sign out</a></li>
						</ul>
					</nav>
				</header>
			</section>
			<div class="central-container" >
				
				<section id="about" class="content">
					<h2> Upload </h2>
					<h2 id="subheader" style="font-size: 15px !important; text-align:center !important; display:block; margin: 0 400px 5px;"> First Step</h2>
					<p>Go to <a href="https://takeout.google.com/settings/takeout"> Google Takeout</a> to download your Location History data: on this page, deselect everything except Location History by clicking "Select none" and then reselecting "Location History". Then, hit "Next" and, finally, click "Create archive". Once the archive has been created, click "Download".</p>
				</section>
				<section id="portfolio" class="content">
					<h2 style="font-size: 15px !important; text-align:center !important; display:block; margin: 0 400px 5px;">Second Step</h2>
					<p> Unzip the downloaded file, and open the "Location History" folder within. Then, select "Upload" from the menu above.</p>
				</section>
				<section id="services" class="content">
					<h2 style="font-size: 15px !important; text-align:center !important; display:block; margin: 0 400px 5px;">Third Step</h2>
					<p> In order to upload your json file to "Patras Gazer", select "Upload" from the main menu. Then, you get the option to select the areas you want to exclude by clicking the rectangle in the right hand side of the map and by drawing rectangles containing these areas. Then click "Next" (this step is optional, if you want to proceed without excluding any areas, just click "Next"). Click "browse" to select your file or drag and drop it. Finally, click "Upload". If your .json file is larger than 30 mb this might take a while, so please be patient. Notice that "Patras Gazer", does not insert data other than the city of Patras (> 10km from coordinates 38.230462, 21.753150) by default.</p>
				</section>
				<section id="gallery" class="content">
					<h2>Statistics</h2>
					<p> Select year and month, you can also select a range of these values or all the months and years. Then, when you are ready click "Submit" and after a while you will be able to see detailed stats of your data for the selected period. This data includes:
						<ul>
							<li> a graph showing the percentage of records per activity type </li>
							<li> a table showing the time of the day with the most records per activity type and a graph showing the number of records per activity type</li>
							<li> a table showing the day with the most records per activity type and a graph showing the number of records per activity type</li>
							<li> a heatmap showing your locations for the selected period</li>
						</ul>
					</p>
				</section>
				<section id="contact" class="content">
					<h2>Contact</h2>
					<p>For any information needed you can contact us by clicking <a href="https://rkapsalis.github.io/page/#contact">here</a>. </p>
				</section>
			</div>
		</body>
		<footer>
			<ul class="social">
				<p><span class="footer__copyright">Romanos Kapsalis &copy;</span> 2020 </p>
				<li><a href="https://www.linkedin.com/in/romanos-kapsalis/" style="padding: 0px 0px 0px 68px" target="_blank"><i class="icon-linkedin"></i></a></li>
				<li><a href="https://github.com/rkapsalis" target="_blank"><i class="icon-github"></i></a></li>
			</ul>
		</footer>
	</html>