<?php
session_start();
if (!isset($_SESSION['rememberMe'])) {
    header('Location: main.php');
    session_destroy();
    exit();
}
?>
<!DOCTYPE html>
<meta name="viewport"  charset="UTF8" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no"/>
<link rel="icon"
  type="image/png"
  href="yellow_low res.png">
  <title>Heatmap | Patras Gazer</title>
  <link rel="stylesheet" href="admin.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800">
  <link rel="stylesheet" href='https://netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css'>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css" integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz" crossorigin="anonymous">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.js"></script>
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css"
    integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ=="
    crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js"
    integrity="sha512-gZwIG9x3wUXg2hdXF6+rVkLF/0Vi9U8D2Ntg4Ga5I5BZpVkVxlJWbSQtXPSiUTtC0TjtGOmxa1AJPuV0CPthew=="
    crossorigin=""></script>
    <script src="\Leaflet.heat-gh-pages\dist\leaflet-heat.js"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="admin_maps.js"></script>
    <style> .content{width:1000px !important;}</style>
    <body>
      <header>
        <section>
          <img src="yellow_low res.png" style="padding: 20px 0px 5px 0px" height="35" width="44">
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
        </section>
      </header>
      <section id="about" class="content">        
        <p>Please pick month, day, activity, time (hour, pm or am and minutes) and year. You can also pick range of these values and then click submit.</p>
        <div id="select-box">
          <div id=block1>
            <h3>Day</h3>
            <h5>since:</h5>
            <select
              name="daysince"
              id="daysince"
              >
              <option value="ALL" selected>ALL </option>
              <option value="0">Δευτέρα</option>
              <option value="1">Τρίτη</option>
              <option value="2">Τετάρτη</option>
              <option value="3">Πέμπτη</option>
              <option value="4">Παρασκευή</option>
              <option value="5">Σάββατο</option>
              <option value="6">Κυριακή</option>
            </select>
            <h5>until:</h5>
            <select
              name="dayuntil"
              id="dayuntil"
              >
              <option value="ALL" selected>ALL </option>
              <option value="0">Δευτέρα</option>
              <option value="1">Τρίτη</option>
              <option value="2">Τετάρτη</option>
              <option value="3">Πέμπτη</option>
              <option value="4">Παρασκευή</option>
              <option value="5">Σάββατο</option>
              <option value="6">Κυριακή</option>
            </select>
            <h3>Hour (Since)</h3>
            <h5 id="hour1">h:</h5>
            <select name="hoursince" id="hoursince" >
              <option value="ALL">ALL </option>
              <option value="01">01</option>
              <option value="02">02</option>
              <option value="03">03</option>
              <option value="04">04</option>
              <option value="05">05</option>
              <option value="06">06</option>
              <option value="07">07</option>
              <option value="08">08</option>
              <option value="09">09</option>
              <option value="10">10</option>
              <option value="11">11</option>
              <option value="12">12</option>
            </select>
            <select name="am-pm" id="am-pm">
              <option value="ALL">ALL </option>
              <option value="AM">AM</option>
              <option value="PM">PM</option>
            </select>
            <h5>m:</h5>
            <select name="minutessince" id="minutessince">
              <option value="ALL">ALL </option>
            </select>
            
          </div>
          
          <div id=block2>
            <h3>Month</h3>
            <h5>since:</h5>
            <select
              name="monthsince"
              id="monthsince"
              
              >
              <option value="ALL" selected>ALL</option>
              <option value="01">Ιανουάριος</option>
              <option value="02">Φεβρουάριος</option>
              <option value="03">Μάρτιος</option>
              <option value="04">Απρίλιος</option>
              <option value="05">Μάιος</option>
              <option value="06">Ιούνιος</option>
              <option value="07">Ιούλιος</option>
              <option value="08">Αύγουστος</option>
              <option value="09">Σεπτέμβριος</option>
              <option value="10">Οκτώβριος</option>
              <option value="11">Νοέμβριος</option>
              <option value="12">Δεκέμβριος</option>
            </select>
            <h5>until:</h5>
            <select
              name="monthuntil"
              id="monthuntil"
              
              >
              <option value="ALL" selected>ALL </option>
              <option value="01">Ιανουάριος</option>
              <option value="02">Φεβρουάριος</option>
              <option value="03">Μάρτιος</option>
              <option value="04">Απρίλιος</option>
              <option value="05">Μάιος</option>
              <option value="06">Ιούνιος</option>
              <option value="07">Ιούλιος</option>
              <option value="08">Αύγουστος</option>
              <option value="09">Σεπτέμβριος</option>
              <option value="10">Οκτώβριος</option>
              <option value="11">Νοέμβριος</option>
              <option value="12">Δεκέμβριος</option>
            </select>
            <h3>Hour (Until)</h3>
            <h5 id="hour2">h:</h5>
            <select name="houruntil" id="houruntil" >
              <option value="ALL">ALL </option>
              <option value="01">01</option>
              <option value="02">02</option>
              <option value="03">03</option>
              <option value="04">04</option>
              <option value="05">05</option>
              <option value="06">06</option>
              <option value="07">07</option>
              <option value="08">08</option>
              <option value="09">09</option>
              <option value="10">10</option>
              <option value="11">11</option>
              <option value="12">12</option>
            </select>
            <select name="am-pm2" id="am-pm2">
              <option value="ALL">ALL </option>
              <option value="AM">AM</option>
              <option value="PM">PM</option>              
            </select>
            <h5>m:</h5>
            <select name="minutesuntil" id="minutesuntil">
              <option value="ALL" selected>ALL </option>              
            </select>
            
          </div>
          <div id="block3">
            
            <h3>Year</h3>
            <h5>since:</h5>
            <select name="yearsince" id="yearsince">
              <option value="ALL">ALL</option>
            </select>
            <h5>until:</h5>
            <select
              name="yearuntil"
              id="yearuntil"
              
              >
              <option value="ALL">ALL</option>
            </select>
            <h3>Activity</h3>
            <div class="dropdown" data-control="checkbox-dropdown">
              <label class="dropdown-label">Select</label>
              <div class="dropdown-list">
                <a href="#" data-toggle="check-all" class="dropdown-option">
                  Check All
                </a>
              </div>
            </div>
            
          </div>
          <button type="submit" id="submitrange" class="button">Submit</button>
        </div>
      </section>
      <!-- </section> -->
      <div class="central-container" style="display:none;">
        <section id="contact" class="content" style="display:none;">
          <h2>Heatmap</h2>
          <div id="mapid"></div>
        </section>
        <section id="portfolio" class="content" style="display:none;">
          <h2>Export Data</h2>
          <button type="submit" id="CSVbutton" class="button">CSV</button>
          <button type="submit" id="XMLbutton" href="xml.png" class="button">XML</button>
          <button type="submit" id="JSONbutton" class="button">JSON</button>
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