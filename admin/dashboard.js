 $(document).ready(function() {
              

      $.ajax({    //create an ajax request to display.php
        type: "POST",
        url: "dashboard.php",             
        dataType: "json",                   
        success: function(response){       
            console.log(response);
			
			
// for (i=0;i<max;i++){
//     el=json.data[i];
//     data['labels'][i]=el.nome;
//     data['datasets'][0].data[i]=el.n;
//     data['datasets'][0].backgroundColor[i]=getRandomColor();
// }
var days= [];
var days_sum = [];
for(var i in response['day']){
  console.log(i); // alerts key
  //alerts key's value
  days.push(i);
  days_sum.push(response['day'][i])
}
console.log(days_sum); 	
console.log(days);

var months= [];
var months_sum = [];
for(var i in response['month']){
  console.log(i); // alerts key
  //alerts key's value
  months.push(i);
  months_sum.push(response['month'][i])
}
console.log(months_sum);  
console.log(months);

var years = [];
var years_sum = [];
for(var i in response['year']){
  console.log(i); // alerts key
  //alerts key's value
  years.push(i);
  years_sum.push(response['year'][i])
}
console.log(years_sum);  
console.log(years);

var hours = [];
var hours_sum = [];
for(var i in response['hour']){
  console.log(i); // alerts key
  //alerts key's value
  hours.push(i);
  hours_sum.push(response['hour'][i])
}
console.log(hours_sum);  
console.log(hours);

var types = [];
var types_sum = [];
for(var i in response['type']){
  console.log(i); // alerts key
  //alerts key's value
  types.push(i);
  types_sum.push(response['type'][i])
}
console.log(types_sum);  
console.log(types);

//function annual(months) {
var ctx = document.getElementById('annual');
Chart.defaults.global.defaultFontColor = 'black';	
var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: years,
        datasets: [{
            
        barThickness: 12,
        
            label: 'records per year',
            data:   years_sum,
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
        defaultFontColor:'black',
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        },
        data:{
            labels: {
                // This more specific font property overrides the global property
                fontColor: 'black'
            }
        }
    }
});	

var ctx = document.getElementById('hourly');
Chart.defaults.global.defaultFontColor = 'black';   
var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: hours,
        datasets: [{
            
        barThickness: 12,
        
            label: 'records per hour',
            data:   hours_sum,
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
        defaultFontColor:'black',
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        },
        data:{
            labels: {
                // This more specific font property overrides the global property
                fontColor: 'black'
            }
        }
    }
}); 

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
            data:  days_sum,
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
        defaultFontColor:'black',
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        },
        data:{
            labels: {
                // This more specific font property overrides the global property
                fontColor: 'black'
            }
        }
    }
}); 

var ctx = document.getElementById('monthly');
Chart.defaults.global.defaultFontColor = 'black';   
var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: months,
        datasets: [{
            
        barThickness: 12,
        
            label: 'records per month',
            data:   months_sum,
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
        defaultFontColor:'black',
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        },
        data:{
            labels: {
                // This more specific font property overrides the global property
                fontColor: 'black'
            }
        }
    }
}); 
 new Chart(document.getElementById("activities"), {
                        type: 'pie',
                        data: {
                          labels: types ,
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
                                'rgba(217, 233, 21, 1)'
                            ] ,
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
  },
        error: function(XMLHttpRequest, textStatus, errorThrown){
           //console.log(response);
           alert("Status: " + textStatus); alert("Error: " + errorThrown); 
        }
      });





//}
});
 
