 $(document).ready(function() {
              

      $.ajax({    //create an ajax request to display.php
        type: "POST",
        url: "dashboard.php",             
        dataType: "json",                   
        success: function(response){       
            console.log(response);
			
			
        },
		error: function(XMLHttpRequest, textStatus, errorThrown){
		   //console.log(response);
		   alert("Status: " + textStatus); alert("Error: " + errorThrown); 
		}
      });

	

//function annual(months) {
var ctx = document.getElementById('annual');
Chart.defaults.global.defaultFontColor = 'black';	
var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
        datasets: [{
            
        barThickness: 12,
        
            label: 'eco-score',
            data:   [1,2,3,4,5,6,7,8,9,10,11,12],
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
        labels: ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'],
        datasets: [{
            
        barThickness: 12,
        
            label: 'eco-score',
            data:   [1,2,3,4,5,6,7,8,9,10,11,12],
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
        labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
        datasets: [{
            
        barThickness: 12,
        
            label: 'eco-score',
            data:   [1,2,3,4,5,6,7,8,9,10,11,12],
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
                          labels: ['walking','still','on vehicle'] ,
                          datasets: [{
                            label: "Percentage of records per activity type",
                            backgroundColor: ["#3e95cd", "#8e5ea2","#3cba9f","#e8c3b9","#c45850","#d47850"],
                            data: [5,10,30]
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
//}
});