 $(document).ready(function() {
     var $sel = jQuery('#monthsince').val();

     $.ajax({ //create an ajax request to display.php
         type: "POST",
         url: "user_stats_helper.inc.php",
         data: {

         },
         dataType: "json",
         success: function(response) {
             console.log(response);
             for ($i = 0; $i < response['years'].length; $i++) {
                 $("#yearsince").append(" <option value= " + response['years'][$i] + ">" + response['years'][$i] + "</option>");
             }
             for ($i = 0; $i < response['years'].length; $i++) {
                 $("#yearuntil").append(" <option value= " + response['years'][$i] + ">" + response['years'][$i] + "</option>");
             }


         },
         error: function(XMLHttpRequest, textStatus, errorThrown) {
             //console.log(response);
             alert("Status: " + textStatus);
             alert("Error: " + errorThrown);
         }
     });

     $(".button").click(function() {
         var $month_s = jQuery('#monthsince').val();
         var $month_u = jQuery('#monthuntil').val();
         var $year_s = jQuery('#yearsince').val();
         var $year_u = jQuery('#yearuntil').val();

         $.ajax({ //create an ajax request to display.php
             type: "POST",
             url: "user_stats.inc.php",
             data: {
                 month_s: $month_s,
                 month_u: $month_u,
                 year_s: $year_s,
                 year_u: $year_u
             },
             dataType: "json",
             success: function(response) {

                 $('.central-container').show();
                 $('#portfolio').show();
                 $('#services').show();
                 $('#gallery').show();
                 $('#contact').show();
                 
                 var dynamicColors = function() {
                     var r = Math.floor(Math.random() * 255);
                     var g = Math.floor(Math.random() * 255);
                     var b = Math.floor(Math.random() * 255);
                     // var o = 0.8;
                     //console.log("rgba(" + r + "," + g + "," + b + "," + o +")");
                     return "rgb(" + r + "," + g + "," + b + ")";
                 };
                 var coloR = [];
                 for (var i in response['sum']) {

                     coloR.push(dynamicColors());
                 }

                 //-----------------------------------------------------------percentage graph----------------------------------------------------
                 new Chart(document.getElementById("percentage"), {
                     type: 'pie',
                     data: {
                         labels: response['type'],
                         datasets: [{
                             label: "Percentage of records per activity type",
                             data: response['sum'],
                             backgroundColor: coloR,
                             borderWidth: 1
                         }]
                     },
                     options: {
                     	 maintainAspectRatio: false,
                         title: {
                             display: true,
                             text: ' '
                         },
                          legend: {
                            labels:{boxWidth: 15},
                            display:false,
                           position: 'top',
                           align: 'start',
                          }
                     }
                     //}
                 });
                 Chart.defaults.global.defaultFontColor = 'black';
                 //most frequent hours graph
                 var ctx = document.getElementById('sum_ph');
                 var myChart = new Chart(ctx, {
                     type: 'bar',
                     data: {
                         labels: response['type'],
                         datasets: [{
                             label: 'Number of records',
                             data: response['sum_ph'],
                             backgroundColor: coloR,
                             // [
                             //     'rgba(255, 99, 132, 0.8)',
                             //     'rgba(54, 162, 235, 0.8)',
                             //     'rgba(255, 206, 86, 0.8)',
                             //     'rgba(75, 192, 192, 0.8)',
                             //     'rgba(153, 102, 255, 0.8)',
                             //     'rgba(43, 59, 62, 0.8)',
                             //     'rgba(120, 159, 64, 0.8)',
                             //     'rgba(420, 49, 264, 0.8)',
                             //     'rgba(4, 58, 154, 0.8)',
                             //     'rgba(320, 159, 64, 0.8)',
                             //     'rgba(20, 139, 64, 0.8)',
                             //     'rgba(217, 233, 21, 0.8)'
                             // ],
                             borderColor: 'rgba(200, 200, 200, 0.75)',
                             // [
                             //     'rgba(255, 99, 132, 1)',
                             //     'rgba(54, 162, 235, 1)',
                             //     'rgba(255, 206, 86, 1)',
                             //     'rgba(75, 192, 192, 1)',
                             //     'rgba(153, 102, 255, 1)',
                             //     'rgba(43, 59, 62, 1)',
                             //     'rgba(120, 159, 64, 1)',
                             //     'rgba(420, 49, 264, 1)',
                             //     'rgba(4, 58, 154, 1)',
                             //     'rgba(320, 159, 64, 1)',
                             //     'rgba(20, 139, 64, 1)',
                             //     'rgba(217, 233, 21, 1)'
                             // ],
                             borderWidth: 1
                         }]
                     },
                     options: {
                     	 maintainAspectRatio: false,
                         scales: {
                             yAxes: [{
                                 ticks: {
                                     beginAtZero: true
                                 }
                             }]
                         }
                     }
                 });
                 //most frequent hours table
                 var html = '<table>';
                 html += '<tr>';

                 html += '<th>' + 'Type' + '</th>';
                 html += '<th>' + 'Most frequent hour' + '</th>';


                 html += '</tr>';
                 //for( var i = 0; i < response['hour'].length; i++) {

                 for (var j in response['type']) {
                     html += '<tr>';
                     html += '<td>' + response['type'][j] + '</td>';
                     html += '<td>' + response['hour'][j] + '</td>';
                     html += '</tr>';
                 }

                 html += '</table>';
                 document.getElementById('table0').innerHTML = html;

                 //most frequent days graph
                 var ctx = document.getElementById('sum_pd');
                 var myChart = new Chart(ctx, {
                     type: 'bar',
                     data: {
                         labels: response['type'],
                         datasets: [{
                             label: 'Number of records',
                             data: response['sum_pd'],
                             backgroundColor: coloR,
                             // [
                             //     'rgba(255, 99, 132, 0.8)',
                             //     'rgba(54, 162, 235, 0.8)',
                             //     'rgba(255, 206, 86, 0.8)',
                             //     'rgba(75, 192, 192, 0.8)',
                             //     'rgba(153, 102, 255, 0.8)',
                             //     'rgba(43, 59, 62, 0.8)',
                             //     'rgba(120, 159, 64, 0.8)',
                             //     'rgba(420, 49, 264, 0.8)',
                             //     'rgba(4, 58, 154, 0.8)',
                             //     'rgba(320, 159, 64, 0.8)',
                             //     'rgba(20, 139, 64, 0.8)',
                             //     'rgba(217, 233, 21, 0.8)'
                             // ],
                             borderColor: 'rgba(200, 200, 200, 0.75)',
                             //  [
                             //     'rgba(255, 99, 132, 1)',
                             //     'rgba(54, 162, 235, 1)',
                             //     'rgba(255, 206, 86, 1)',
                             //     'rgba(75, 192, 192, 1)',
                             //     'rgba(153, 102, 255, 1)',
                             //     'rgba(43, 59, 62, 1)',
                             //     'rgba(120, 159, 64, 1)',
                             //     'rgba(420, 49, 264, 1)',
                             //     'rgba(4, 58, 154, 1)',
                             //     'rgba(320, 159, 64, 1)',
                             //     'rgba(20, 139, 64, 1)',
                             //     'rgba(217, 233, 21, 1)'
                             // ],
                             borderWidth: 1
                         }]
                     },
                     options: {
                     	 maintainAspectRatio: false,
                         scales: {
                             yAxes: [{
                                 ticks: {
                                     beginAtZero: true
                                 }
                             }]
                         }
                     }
                 });
                 //most frequent days table
                 var html = '<table>';
                 html += '<tr>';

                 html += '<th>' + 'Type' + '</th>';
                 html += '<th>' + 'Most frequent day' + '</th>';


                 html += '</tr>';
                 //for( var i = 0; i < response['hour'].length; i++) {

                 for (var j in response['type']) {
                     html += '<tr>';
                     html += '<td>' + response['type'][j] + '</td>';
                     html += '<td>' + response['day'][j] + '</td>';
                     html += '</tr>';
                 }

                 html += '</table>';
                 document.getElementById('table1').innerHTML = html;
               
                 //heatmap
                 let mymap = L.map('mapid');

                 let osmUrl = 'https://tile.openstreetmap.org/{z}/{x}/{y}.png';
                 let osmAttrib = 'Map data © <a href="https://openstreetmap.org">OpenStreetMap</a> contributors';
                 let osm = new L.TileLayer(osmUrl, {
                     attribution: osmAttrib
                 });
                
                 mymap.addLayer(osm);
                 mymap.setView([38.246242, 21.7350847], 16);
                 var heat = L.heatLayer(response['lon']).addTo(mymap),
                     draw = true;
                 

             },
             error: function(XMLHttpRequest, textStatus, errorThrown) {
                 //console.log(response);
                 alert("Status: " + textStatus);
                 alert("Error: " + errorThrown);
             }
         });

     });

 });