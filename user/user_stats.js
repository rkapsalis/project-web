 $(document).ready(function() {
              

      $.ajax({    //create an ajax request to display.php
        type: "POST",
        url: "user_stats.inc.php",             
        dataType: "json",                   
        success: function(response){       
            console.log(response);
            for ($i = 0; $i < 4; $i++){
                $("#yearsince").append(" <option >" + response[$i] + "</option>");
            }

     
			
      },
		error: function(XMLHttpRequest, textStatus, errorThrown){
		   //console.log(response);
		   alert("Status: " + textStatus); alert("Error: " + errorThrown); 
		}
      });
	     });
