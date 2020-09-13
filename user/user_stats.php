<?php
session_start();
if (!isset($_SESSION['rememberMe'])) {
    header('Location: main.php');
    session_destroy();
    exit();
}
?>
<html>
    <meta name="viewport"  charset="UTF8" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no"/>
    <link rel="icon"
        type="image/png"
        href="yellow_high res.png">
        <title>Statistics | Patras Gazer</title>
        
        <link rel="stylesheet" href="usr.css">
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
            <script src="user_stats.js"></script>
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
                <section id="about" class="content">
                    
                    <p id="text_picker" style="margin-right: 560px;">Please pick month and year (you can also pick range of these values) and then click sumbit.</p>
                    <div id="select-box">
                        <h3>Since</h3>
                        <h5>Month</h5>
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
                        <h5>Year</h5>
                        <select
                            name="yearsince"
                            id="yearsince"
                            
                            >
                            <option value="ALL">ALL </option>
                        </select>
                        <h3>Until</h3>
                        <h5>Month</h5>
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
                        <h5>Year</h5>
                        <select
                            name="yearuntil"
                            id="yearuntil"
                            
                            >
                            <option value="ALL">ALL </option>
                        </select>
                        <button type="submit" id="submitrange" class="button">Submit</button>
                    </div>
                </section>
            </section>
            <div class="central-container" style="display:none;">
                <section id="portfolio" class="content"  style="display:none;">
                    <h2 >Percentage of records per activity type</h2>
                    <div class="pill-wrapper ">
                        <div class="pill">
                            <div class="pill__content">
                                <div class="pill__title">Percentage of records per activity type</div>
                                <div class="pill__value" id="range"> </div>
                                <div class="chart_cont1" >
                                    <canvas id="percentage" width="400" height="400"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <section id="services" class="content" style="display:none;">
                    <h2> The time of the day with the most records per activity type</h2>
                    <div class="pill-wrapper ">
                        <div class="pill">
                            <div class="pill__content">
                                <div class="pill__title">Number of records at this time of the day per activity type</div>
                                <div class="pill__value" id="range"> </div>
                                <div class="chart_cont">
                                    <canvas id="sum_ph" width="400" height="400"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="pill">
                            <div class="pill__content">
                                <div class="pill__title">The time of the day with the most records per activity type</div>
                                <div class="pill__value" id="range"> </div>
                            <table id="table0"></table>
                        </div>
                    </div>
                </div>
            </section>
            <section id="gallery" class="content" style="display:none;">
                <h2>The day with the most records per activity type</h2>
                <div class="pill-wrapper ">
                    <div class="pill">
                        <div class="pill__content">
                            <div class="pill__title">Number of records at this day per activity type </div>
                            <div class="pill__value" id="range"> </div>
                            <div class="chart_cont2">
                                <canvas id="sum_pd" width="400" height="400"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="pill">
                        <div class="pill__content">
                            <div class="pill__title">The day with the most records per activity type </div>
                            <div class="pill__value" id="range"> </div>
                        <table id="table1"></table>
                    </div>
                </div>
            </div>
        </section>
        <section id="contact" class="content" style="display:none;">
            <h2>Heatmap</h2>
            
            <div class="map-container">
                <div id="mapid"></div>
            </div>
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