 $(document).ready(function() {


     $.ajax({ //create an ajax request to display.php
         type: "POST",
         url: "dashboard.php",
         dataType: "json",
         success: function(response) {
             console.log(response);

             $('.welcome').append(" <h3>Welcome back, <br /> admin!</h3>");

             var days = [];
             var days_sum = [];
             for (var i in response['day']) {
                 days.push(i);
                 days_sum.push(response['day'][i])
             }

             var months = [];
             var months_sum = [];
             for (var i in response['month']) {
                 months.push(i);
                 months_sum.push(response['month'][i])
             }

             var years = [];
             var years_sum = [];
             for (var i in response['year']) {
                 years.push(i);
                 years_sum.push(response['year'][i])
             }

             var hours = [];
             var hours_sum = [];
             for (var i in response['hour']) {
                 hours.push(i);
                 hours_sum.push(response['hour'][i])
             }

             var types = [];
             var types_sum = [];
             for (var i in response['type']) {
                 types.push(i);
                 types_sum.push(response['type'][i])
             }

             var user = [];
             var user_sum = [];
             for (var i in response['user']) {
                 user.push(i);
                 user_sum.push(response['user'][i])
             }

             //create chart1
             var ctx = document.getElementById('annual');
             Chart.defaults.global.defaultFontColor = 'black';
             var myChart = new Chart(ctx, {
                 type: 'bar',
                 data: {
                     labels: years,
                     datasets: [{

                         barThickness: 12,

                         label: 'records per year',
                         data: years_sum,
                         backgroundColor: [
                             'rgba(255, 99, 132, 1)',
                             'rgba(54, 162, 235, 1)',
                             'rgba(255, 206, 86, 1)',
                             'rgba(75, 192, 192, 1)',
                             'rgba(153, 102, 255, 1)',
                             'rgba(43, 59, 62, 1)',
                             'rgba(120, 159, 64, 1)',
                             'rgba(420, 49, 264, 1)',
                             'rgba(4, 58, 154, 1)',
                             'rgba(320, 159, 64, 1)',
                             'rgba(20, 139, 64, 1)',
                             'rgba(217, 233, 21, 1)'
                         ],
                         borderColor: [
                             'rgba(255, 99, 132, 1)',
                             'rgba(54, 162, 235, 1)',
                             'rgba(255, 206, 86, 1)',
                             'rgba(75, 192, 192, 1)',
                             'rgba(153, 102, 255, 1)',
                             'rgba(43, 59, 62, 1)',
                             'rgba(120, 159, 64, 1)',
                             'rgba(420, 49, 264, 1)',
                             'rgba(4, 58, 154, 1)',
                             'rgba(320, 159, 64, 1)',
                             'rgba(20, 139, 64, 1)',
                             'rgba(217, 233, 21, 1)'
                         ],
                         borderWidth: 1
                     }]
                 },
                 options: {
                     defaultFontColor: 'black',
                     scales: {
                         yAxes: [{
                             ticks: {
                                 beginAtZero: true
                             }
                         }]
                     },
                     data: {
                         labels: {
                             // This more specific font property overrides the global property
                             fontColor: 'black'
                         }
                     }
                 }
             });
             var dynamicColors = function() {
                 var r = Math.floor(Math.random() * 255);
                 var g = Math.floor(Math.random() * 255);
                 var b = Math.floor(Math.random() * 255);
                 return "rgb(" + r + "," + g + "," + b + ")";
             };
             //create chart2
             var ctx = document.getElementById('hourly');
             Chart.defaults.global.defaultFontColor = 'black';
             var myChart = new Chart(ctx, {
                 type: 'line',
                 data: {
                     labels: hours,
                     datasets: [{

                         barThickness: 12,

                         label: 'records per hour',
                         data: hours_sum,
                         backgroundColor: 'rgb(255, 99, 132,0.6)',
                         borderColor: 'rgba(200, 200, 200, 0.75)',
                         borderWidth: 1
                     }]
                 },
                 options: {
                     fill: true,
                     defaultFontColor: 'black',
                     scales: {
                         yAxes: [{
                             ticks: {
                                 beginAtZero: true
                             }
                         }]
                     },
                     data: {
                         labels: {
                             // This more specific font property overrides the global property
                             fontColor: 'black'
                         }
                     }
                 }
             });

             //create chart3
             var ctx = document.getElementById('daily');
             Chart.defaults.global.defaultFontColor = 'black';
             var myChart = new Chart(ctx, {
                 type: 'bar',
                 data: {
                     // labels: ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'],
                     labels: days,
                     datasets: [{

                         barThickness: 12,

                         label: 'records per day',
                         data: days_sum,

                         backgroundColor: [
                             'rgba(255, 99, 132, 0.75)',
                             'rgba(54, 162, 235, 0.75)',
                             'rgba(255, 206, 86, 0.75)',
                             'rgba(75, 192, 192, 0.75)',
                             'rgba(153, 102, 255, 0.75)',
                             'rgba(43, 59, 62, 0.75)',
                             'rgba(120, 159, 64, 0.75)',
                             'rgba(420, 49, 264, 0.75',
                             'rgba(4, 58, 154, 0.75)',
                             'rgba(320, 159, 64, 0.75)',
                             'rgba(20, 139, 64, 0.75)',
                             'rgba(217, 233, 21, 0.75)'
                         ],

                         borderColor: [
                             'rgba(255, 99, 132, 1)',
                             'rgba(54, 162, 235, 1)',
                             'rgba(255, 206, 86, 1)',
                             'rgba(75, 192, 192, 1)',
                             'rgba(153, 102, 255, 1)',
                             'rgba(43, 59, 62, 1)',
                             'rgba(120, 159, 64, 1)',
                             'rgba(420, 49, 264, 1)',
                             'rgba(4, 58, 154, 1)',
                             'rgba(320, 159, 64, 1)',
                             'rgba(20, 139, 64, 1)',
                             'rgba(217, 233, 21, 1)'
                         ],
                         borderWidth: 1
                     }]
                 },
                 options: {
                     defaultFontColor: 'black',
                     scales: {
                         yAxes: [{
                             ticks: {
                                 beginAtZero: true
                             }
                         }]
                     },
                     data: {
                         labels: {
                             // This more specific font property overrides the global property
                             fontColor: 'black'
                         }
                     }
                 }
             });

             //create chart4
             var ctx = document.getElementById('monthly');
             Chart.defaults.global.defaultFontColor = 'black';
             var myChart = new Chart(ctx, {
                 type: 'bar',
                 data: {
                     labels: months,
                     datasets: [{

                         barThickness: 12,

                         label: 'records per month',
                         data: months_sum,
                         backgroundColor: [
                             'rgba(255, 99, 132, 1)',
                             'rgba(54, 162, 235, 1)',
                             'rgba(255, 206, 86, 1)',
                             'rgba(75, 192, 192, 1)',
                             'rgba(153, 102, 255, 1)',
                             'rgba(43, 59, 62, 1)',
                             'rgba(120, 159, 64, 1)',
                             'rgba(420, 49, 264, 1)',
                             'rgba(4, 58, 154, 1)',
                             'rgba(320, 159, 64, 1)',
                             'rgba(20, 139, 64, 1)',
                             'rgba(217, 233, 21, 1)'
                         ],
                         borderColor: [
                             'rgba(255, 99, 132, 1)',
                             'rgba(54, 162, 235, 1)',
                             'rgba(255, 206, 86, 1)',
                             'rgba(75, 192, 192, 1)',
                             'rgba(153, 102, 255, 1)',
                             'rgba(43, 59, 62, 1)',
                             'rgba(120, 159, 64, 1)',
                             'rgba(420, 49, 264, 1)',
                             'rgba(4, 58, 154, 1)',
                             'rgba(320, 159, 64, 1)',
                             'rgba(20, 139, 64, 1)',
                             'rgba(217, 233, 21, 1)'
                         ],
                         borderWidth: 1
                     }]
                 },
                 options: {
                     defaultFontColor: 'black',
                     scales: {
                         yAxes: [{
                             ticks: {
                                 beginAtZero: true
                             }
                         }]
                     },
                     data: {
                         labels: {
                             // This more specific font property overrides the global property
                             fontColor: 'black'
                         }
                     }
                 }
             });

             //create chart5
             new Chart(document.getElementById("activities"), {
                 type: 'pie',
                 data: {
                     labels: types,
                     datasets: [{
                         label: "Percentage of records per activity type",
                         backgroundColor: [
                             'rgba(255, 99, 132, 1)',
                             'rgba(54, 162, 235, 1)',
                             'rgba(255, 206, 86, 1)',
                             'rgba(75, 192, 192, 1)',
                             'rgba(153, 102, 255, 1)',
                             'rgba(43, 59, 62, 1)',
                             'rgba(120, 159, 64, 1)',
                             'rgba(420, 49, 264, 1)',
                             'rgba(4, 58, 154, 1)',
                             'rgba(320, 159, 64, 1)',
                             'rgba(20, 139, 64, 1)',
                             'rgba(217, 233, 21, 1)',
                             'rgba(66,15,100,1)',
                             'rgba(520, 69, 64, 1)',
                             'rgba(66,15,10,1)'
                         ],
                         data: types_sum
                     }]
                 },
                 options: {
                     title: {
                         display: true,
                         text: ' '
                     }
                 }
                 //}
             });

             //create chart6
             new Chart(document.getElementById("users"), {
                 type: 'bar',
                 data: {
                     labels: user,
                     datasets: [{
                         label: "users",
                         backgroundColor: [
                             'rgba(255, 99, 132, 1)',
                             'rgba(54, 162, 235, 1)',
                             'rgba(255, 206, 86, 1)',
                             'rgba(75, 192, 192, 1)',
                             'rgba(153, 102, 255, 1)',
                             'rgba(43, 59, 62, 1)',
                             'rgba(120, 159, 64, 1)',
                             'rgba(420, 49, 264, 1)',
                             'rgba(4, 58, 154, 1)',
                             'rgba(320, 159, 64, 1)',
                             'rgba(20, 139, 64, 1)',
                             'rgba(217, 233, 21, 1)',
                             'rgba(66,15,100,1)',
                             'rgba(520, 69, 64, 1)',
                             'rgba(66,15,10,1)'
                         ],
                         data: user_sum,
                     }]
                 },
                 options: {
                     title: {
                         display: true,
                         text: ' '
                     },
                     scales: {
                         xAxes: [{
                             scaleLabel: {
                                 display: true,
                                 labelString: 'records'
                             }
                         }],

                         yAxes: [{
                             scaleLabel: {
                                 display: true,
                                 labelString: 'users'
                             }
                         }]
                     }
                 }
                 //}
             });
         },
         error: function(XMLHttpRequest, textStatus, errorThrown) {
             //console.log(response);
             alert("Status: " + textStatus);
             alert("Error: " + errorThrown);
         }
     });
     //}
 });