<?php
session_start();
if (!isset($_SESSION['rememberMe'])) {
    header('Location: main.php');
    session_destroy();
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
  <meta charset="utf-8">
  <link rel="icon"
    type="image/png"
    href="yellow_high res.png">
    <title>Upload | Patras Gazer</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
    <link href="upload1.css" rel="stylesheet">
    <link rel="stylesheet" href="usr.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.4/dist/leaflet.css"/>
    <link rel="stylesheet" href='https://netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css" integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz" crossorigin="anonymous">
    <script src="https://unpkg.com/leaflet@1.3.4/dist/leaflet.js" ></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/0.4.2/leaflet.draw.css"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/0.4.2/leaflet.draw.js"></script>
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
        </section>
      </header>
      
      <div class="container">
        <div class="wrapper">
          <ul class="steps">
            <li class="is-active">Step 1</li>
            <li>Step 2</li>
            <li>Step 3</li>
          </ul>
          <form class="form-wrapper" id="upload2" action="http:/json-machine-master/src/parser1.php" method="POST" enctype="multipart/form-data">
            <fieldset class="section is-active">
              <h3>Please select the area(s) you want to exclude by clicking the rectangle in the map.</h3>
              <div id="mapid"></div>
              <input type="hidden" name="cens" id="cens" value="[]"/>
              <input type="submit"  value="Submit" class="button" id="upload10" name="upload10"/>
            </fieldset>
            <fieldset class="section">
              <div class="container">
                <div class="form-group desktop-upload">
                  <input type="hidden" id="MAX_FILE_SIZE" name="MAX_FILE_SIZE" value="20971520000" />
                  <div>
                    <div id="filedrag">
                      <h2> Please select your .json file</h2>
                      <!-- <img class="box-icon" src="https://upload.wikimedia.org/wikipedia/commons/b/bb/Octicons-cloud-upload.svg" /> -->
                      <img class="box-icon" src="https://image.flaticon.com/icons/svg/617/617517.svg" />
                      <label class="up" for="fileselect">Drop files here or</label>
                      <input type="file" id="fileselect" name="fileselect[]" />
                    </div>
                  </div>
                </div>
                <div class="form-group mobile-upload">
                  <label for="exampleFormControlFile1">Example file input</label>
                  <input type="file" class="form-control-file" id="exampleFormControlFile1" />
                </div>
                <h3 id="status"></h3>
                <button type="submit" id="submitbutton" class="button">Upload File</button>
              </div>
            </fieldset>
            <fieldset class="section" >
              <div id="messages">
                <p></p>
              </div>
              <div id="progress"></div>
              <div class="done" style="display:none;">
              <h3>File Uploaded!</h3>
              <p>Your .json file has been uploaded successfully.</p>
            </div>
              <!-- <div class="button">Cancel</div> -->
            </fieldset>
          </form>
        </div>
      </div>
      <script src="upload1.js"></script>
      <footer style="margin-top: 800px !important; position: absolute; bottom:0;">
        <ul class="social">
          <p><span class="footer__copyright">Romanos Kapsalis &copy;</span> 2020 </p>
          <li><a href="https://www.linkedin.com/in/romanos-kapsalis/" style="padding: 0px 0px 0px 68px" target="_blank"><i class="icon-linkedin"></i></a></li>
          <li><a href="https://github.com/rkapsalis" target="_blank"><i class="icon-github"></i></a></li>
        </ul>
      </footer>
    </body>
  </html>