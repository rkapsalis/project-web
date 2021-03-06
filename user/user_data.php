<?php
session_start();
if (!isset($_SESSION['rememberMe'])) {
    header('Location: main.php');
    session_destroy();
    exit();
}
?>
<!DOCTYPE html>
<html>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no"/>
  <link rel="icon"
    type="image/png"
    href="yellow_high res.png">
    <title>User data | Patras Gazer</title>
    <link rel="stylesheet" href="usr.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800">
    <link rel="stylesheet" href='https://netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css" integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz" crossorigin="anonymous">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="user_data.js"></script>
    <style> body{background-color: #1caff9;} .content p{color:black;}</style>
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
      <main>
        <section id="gallery" class="content" style="margin-bottom: 30px !important;">
          <div class="welcome">
            <img src="patra.jpg" style="padding: 20px 0px 5px 0px; image-rendering: -webkit-optimize-contrast;" height="210" width="100%">
            <!-- <h3>Welcome back, <br /> <?=$_SESSION['name']?>!</h3> -->
          </div>
        </section>
        <div class="central-container">
          <section id="about" class="content">
            <h2>My stats</h2>
            <div class="pill-wrapper">
              <div class="pill">
                <div class="pill__content">
                  <div class="pill__date"> </div>
                  <div class="pill__title">Eco score</div>
                  <div class="pill__value" id="my_eco"> </div>
                </div>
              </div>
              <div class="pill">
                <div class="pill__content">
                  <div class="pill__title">Upload range</div>
                  <div class="pill__value" id="range"> </div>
                </div>
              </div>              
              <div class="pill">
                <div class="pill__content">
                  <div class="pill__title">Latest upload</div>
                  <div class="pill__value" id="last_up"> </div>
                </div>
              </div>
            </div>
          </section>
          <section id="portfolio" class="content">
            <h2>Annual chart</h2>
            <div class="chart_cont">
              <canvas id="annual" style="width:400; height:400"></canvas>
            </div>
          </section>
          <section id="services" class="content">
            <h2>Leaderboard</h2>
            <div class="activity-feed">
              <h3>Current month eco-score</h3>
              <ul class="feed">
                <li class="feed__item user">
                  <div class="user__avatar" id="first"></div>
                  <div class="user__name" id="one"> </div>
                  <div class="user__message">1st</div>
                  <div class="user__score" id="score_one">score: </div>
                </li>
                <li class="feed__item user">
                  <div class="user__avatar" id="second"></div>
                  <div class="user__name" id="two"> </div>
                  <div class="user__message">2nd</div>
                  <div class="user__score" id="score_two">score: </div>
                </li>
                <li class="feed__item user">
                  <div class="user__avatar" id="third"></div>
                  <div class="user__name" id="three"> </div>
                  <div class="user__message">3rd</div>
                  <div class="user__score" id="score_three">score: </div>
                </li>
                <li class="feed__item user">
                  <div class="user__avatar"></div>
                  <div class="user__name" id="my_name"> </div>
                  <div class="user__message" id="my_rank"> </div>
                  <div class="user__score" id="my_score">score: </div>
                </li>
              </ul>
            </div>
          </section>
        </div>
      </main>
    </body>
    <footer>
      <ul class="social">
        <p><span class="footer__copyright">Romanos Kapsalis &copy;</span> 2020 </p>
        <li><a href="https://www.linkedin.com/in/romanos-kapsalis/" style="padding: 0px 0px 0px 68px" target="_blank"><i class="icon-linkedin"></i></a></li>
        <li><a href="https://github.com/rkapsalis" target="_blank"><i class="icon-github"></i></a></li>
      </ul>
    </footer>
  </html>