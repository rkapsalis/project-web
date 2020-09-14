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
    <title>Dashboard | Patras Gazer</title>
    <link rel="stylesheet" href="admin.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800">
    <link rel="stylesheet" href='https://netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css" integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="dashboard.js"></script>
    <body>
      <header>
        <section>
          <img src="yellow_low res.png" style="padding: 20px 0px 5px 0px; image-rendering: -webkit-optimize-contrast;" height="35" width="44">
          <a href="dashboard.php" id="logo" target="_blank">Patras Gazer</a>
          <label for="toggle-1" class="toggle-menu"><ul><li></li> <li></li> <li></li></ul></label>
          <input type="checkbox" id="toggle-1">
          <nav >
            <ul>
              <li><a href="dashboard.php"><i class="fa fa-tachometer-alt"></i>Dashboard</a></li>
              <li><a href="admin_maps.php"><i class="fas fa-map-marker-alt"></i>Heatmap</a></li>
              <li><a href="delete_data.php"><i class="fa fa-trash-alt"></i>Delete</a></li>
              <li><a href="admin_maps.php"><i class="fa fa-file-export"></i>Export</a></li>
              <li><a href="http://localhost/logout.php"><i class="fa fa-sign-out-alt" ></i>Sign out</a></li>
            </ul>
          </nav>
        </header>
      </section>
      <main>
        <section id="gallery" class="content">
          <div class="welcome">
            <img src="patra.jpg" style="padding: 15px 0px 5px 0px; image-rendering: -webkit-optimize-contrast;" height="210" width="100%">
          </div>
        </section>
        <div class="central-container">
          <section id="about" class="content">
            <h2>Distribution of the number of records</h2>
            <div class="pill-wrapper">
              <div class="pill">
                <div class="pill__content">
                  <div class="pill__title">Per activity type</div>
                  <div class="pill__value" id="range"> </div>
                  <div class="chart_cont">
                    <canvas id="activities" width="400" height="400"></canvas>
                  </div>
                </div>
              </div>
              <div class="pill">
                <div class="pill__content">
                  <div class="pill__title">Per user</div>
                  <div class="pill__value" id="my_eco"> </div>
                  <div class="chart_cont">
                    <canvas id="users" width="400" height="400"></canvas>
                  </div>
                </div>
              </div>
            </div>
          </section>
          <section id="portfolio" class="content">
            <div class="pill-wrapper">
              <div class="pill">
                <div class="pill__content">
                  <div class="pill__title">Per month</div>
                  <div class="pill__value" id="my_eco"> </div>
                  <div class="chart_cont">
                    <canvas id="monthly" width="400" height="400"></canvas>
                  </div>
                </div>
              </div>
              <div class="pill">
                <div class="pill__content">
                  <div class="pill__title">Per Day</div>
                  <div class="pill__value" id="last_up"> </div>
                  <div class="chart_cont">
                    <canvas id="daily" width="400" height="400"></canvas>
                  </div>
                </div>
              </div>
            </div>
          </section>
          <section id="portfolio" class="content">
            <div class="pill-wrapper">
              <div class="pill">
                <div class="pill__content">
                  <div class="pill__title">Per Hour</div>
                  <div class="pill__value" id="range"> </div>
                  <div class="chart_cont">
                    <canvas id="hourly" width="400" height="400"></canvas>
                  </div>
                </div>
              </div>
              <div class="pill">
                <div class="pill__content">
                  <div class="pill__date"> </div>
                  <div class="pill__title">Per Year</div>
                  <div class="pill__value" id="my_eco"> </div>
                  <div class="chart_cont">
                    <canvas id="annual" width="400" height="400"></canvas>
                  </div>
                </div>
              </div>
            </div>
          </section>          
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