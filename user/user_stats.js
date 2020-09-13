 $(document).ready(function() {
     var $sel = jQuery('#monthsince').val();
     var mymap;
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
             // alert("Status: " + textStatus);
             // alert("Error: " + errorThrown);
               window.location.href = "main.php";
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
                 $('#percentage').remove(); // this is my <canvas> element
                $('.chart_cont1').append('<canvas id="percentage" width="400" height="400"><canvas>');
                 var myChart1;
                
                 myChart1 = new Chart(document.getElementById("percentage"), {
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
                 //----------------------------------------------------most frequent hours graph-----------------------------------------------
                 
                 var myChart;
                 //remove on button click
                $('#sum_ph').remove(); // this is my <canvas> element
                $('.chart_cont').append('<canvas id="sum_ph" width="400" height="400"><canvas>');
                var ctx = document.getElementById('sum_ph');
                 myChart = new Chart(ctx, {
                     type: 'bar',
                     data: {
                         labels: response['type'],
                         datasets: [{
                             label: 'Number of records',
                             data: response['sum_ph'],
                             backgroundColor: coloR,                            
                             borderColor: 'rgba(200, 200, 200, 0.75)',                             
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
                 var myChart2;
                  //remove on button click
                $('#sum_pd').remove(); // this is my <canvas> element
                $('.chart_cont2').append('<canvas id="sum_pd" width="400" height="400"><canvas>');
                 //most frequent days graph
                 var ctx = document.getElementById('sum_pd');
                 myChart2 = new Chart(ctx, {
                     type: 'bar',
                     data: {
                         labels: response['type'],
                         datasets: [{
                             label: 'Number of records',
                             data: response['sum_pd'],
                             backgroundColor: coloR,                             
                             borderColor: 'rgba(200, 200, 200, 0.75)',                             
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
                  //remove on button click
                 if(mymap != undefined || mymap != null){
                    mymap.off();
                    mymap.remove();                
                   
                 }
                 //heatmap
                 mymap = L.map('mapid');

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