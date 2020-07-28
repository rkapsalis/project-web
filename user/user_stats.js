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
});


     
			
      },
		error: function(XMLHttpRequest, textStatus, errorThrown){
		   //console.log(response);
		   alert("Status: " + textStatus); alert("Error: " + errorThrown); 
		}
      });            

   

      });

	     });
