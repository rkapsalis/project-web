 $(document).ready(function() {
         var $sel = jQuery('#monthsince').val();

      $.ajax({    //create an ajax request to display.php
        type: "POST",
        url: "user_stats_helper.inc.php",
        data: {
        	sel: $sel
        },             
        dataType: "json",                   
        success: function(response){       
            console.log(response);
            for ($i = 0; $i < 4; $i++){
                $("#yearsince").append(" <option value= " + response['years'][$i] + ">" + response['years'][$i] + "</option>");
            }
            for ($i = 0; $i < 4; $i++){
                $("#yearuntil").append(" <option value= " + response['years'][$i] + ">" + response['years'][$i] + "</option>");
            }

     
			
      },
		error: function(XMLHttpRequest, textStatus, errorThrown){
		   //console.log(response);
		   alert("Status: " + textStatus); alert("Error: " + errorThrown); 
		}
      });
     
        $(".button").click(function(){
        	var $month_s = jQuery('#monthsince').val();
        	var $month_u = jQuery('#monthuntil').val();
        	var $year_s = jQuery('#yearsince').val();
        	var $year_u = jQuery('#yearuntil').val();

            alert($month_s);
            alert($year_s);
             $.ajax({    //create an ajax request to display.php
		        type: "POST",
		        url: "user_stats.inc.php",
		        data: {
		        	month_s: $month_s,
		        	month_u: $month_u,
		        	year_s: $year_s,
		        	year_u: $year_u
		        },             
		        dataType: "json",                   
		        success: function(response){       
		            console.log(response);

		             //percentage graph
		             new Chart(document.getElementById("percentage"), {
					    type: 'pie',
					    data: {
					      labels: response['type'],
					      datasets: [{
					        label: "Percentage of records per activity type",
					        backgroundColor: ["#3e95cd", "#8e5ea2","#3cba9f","#e8c3b9","#c45850","#d47850"],
					        data: response['sum']
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

		             //most frequent hours graph
					   var ctx = document.getElementById('sum_ph');	
									var myChart = new Chart(ctx, {
									    type: 'bar',
									    data: {
									        labels: response['type'],
									        datasets: [{
									            label: 'Number of records at this time',
									            data:  response['sum_ph'],
									            backgroundColor: [
									                'rgba(255, 99, 132, 0.2)',
									                'rgba(54, 162, 235, 0.2)',
									                'rgba(255, 206, 86, 0.2)',
									                'rgba(75, 192, 192, 0.2)',
									                'rgba(153, 102, 255, 0.2)',
									                'rgba(43, 59, 62, 0.2)',
													'rgba(120, 159, 64, 0.2)',
													'rgba(420, 49, 264, 0.2)',
													'rgba(4, 58, 154, 0.2)',
													'rgba(320, 159, 64, 0.2)',
													'rgba(20, 139, 64, 0.2)',
													'rgba(217, 233, 21, 0.2)'
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
							
						    html += '<th>'+ 'Type' + '</th>';
						    html += '<th>'+ 'Peak hour' + '</th>';						    
						   
						
							 html += '</tr>';
							 //for( var i = 0; i < response['hour'].length; i++) {
							  
							  for( var j in response['type'] ) {
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
									            label: 'Number of records at this time',
									            data:  response['sum_pd'],
									            backgroundColor: [
									                'rgba(255, 99, 132, 0.2)',
									                'rgba(54, 162, 235, 0.2)',
									                'rgba(255, 206, 86, 0.2)',
									                'rgba(75, 192, 192, 0.2)',
									                'rgba(153, 102, 255, 0.2)',
									                'rgba(43, 59, 62, 0.2)',
													'rgba(120, 159, 64, 0.2)',
													'rgba(420, 49, 264, 0.2)',
													'rgba(4, 58, 154, 0.2)',
													'rgba(320, 159, 64, 0.2)',
													'rgba(20, 139, 64, 0.2)',
													'rgba(217, 233, 21, 0.2)'
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
									        scales: {
									            yAxes: [{
									                ticks: {
									                    beginAtZero: true
									                }
									            }]
									        }
									    }
									});	
							     
			
      },
		error: function(XMLHttpRequest, textStatus, errorThrown){
		   //console.log(response);
		   alert("Status: " + textStatus); alert("Error: " + errorThrown); 
		}
      });            

   

      });

	     });
