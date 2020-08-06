 $(document).ready(function() {
         
      $.ajax({    //create an ajax request to display.php
        type: "POST",
        url: "admin_maps_helper.inc.php",
        data: {
        	
        },             
        dataType: "json",                   
        success: function(response){       
            console.log(response);
            for ($i = 0; $i < response['years'].length; $i++){
                $("#yearsince").append(" <option value= " + response['years'][$i] + ">" + response['years'][$i] + "</option>");
            }
            for ($i = 0; $i < response['years'].length; $i++){
                $("#yearuntil").append(" <option value= " + response['years'][$i] + ">" + response['years'][$i] + "</option>");
            }
            for ($i = 0; $i < response['activities'].length; $i++){
                $("#activity1").append(" <option value= " + response['activities'][$i] + ">" + response['activities'][$i] + "</option>");
            }
            for ($i = 0; $i < response['activities'].length; $i++){
                $("#activity2").append(" <option value= " + response['activities'][$i] + ">" + response['activities'][$i] + "</option>");
            }

			$(function(){
			    var $select = $("#minutessince");
			    var $select1 = $("#minutesuntil");
			    for (i=0;i<=59;i++){
			        $select.append($('<option></option>').val(i).html(i))
			        $select1.append($('<option></option>').val(i).html(i))
			    }
			});
			
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
        	var $activity1 = jQuery('#activity1').val();
        	var $activity2 = jQuery('#activity2').val();
        	var $daysince = jQuery('#daysince').val();
        	var $dayuntil = jQuery('#dayuntil').val();
        	var $hoursince = jQuery('#hoursince').val();
        	var $houruntil = jQuery('#houruntil').val();
        	var $minutessince = jQuery('#minutessince').val();
        	var $minutesuntil = jQuery('#minutesuntil').val();
            var $am_pm = jQuery('#am-pm').val();
        	var $am_pm2 = jQuery('#am-pm2').val();



            alert($month_s);
            alert($year_s);
             $.ajax({    //create an ajax request to display.php
		        type: "POST",
		        url: "admin_maps.php",
		        data: {
		        	month_s: $month_s,
		        	month_u: $month_u,
		        	year_s: $year_s,
		        	year_u: $year_u,
		        	activity1: $activity1,
		        	activity2: $activity2,
		        	dayuntil: $dayuntil,
		        	daysince: $daysince,
					hoursince: $hoursince,  
					houruntil: $houruntil, 
					minutessince: $minutessince,
					minutesuntil: $minutesuntil,
					pm_am_s: $am_pm,
					pm_am_u: $am_pm2,

		        },             
		        dataType: "json",                   
		        success: function(response){       
		            console.log(response);
                            	

                            //heatmap
							let mymap = L.map('mapid')
							let osmUrl='https://tile.openstreetmap.org/{z}/{x}/{y}.png';
							let osmAttrib='Map data © <a href="https://openstreetmap.org">OpenStreetMap</a> contributors';
							let osm = new L.TileLayer(osmUrl, {attribution: osmAttrib});
							mymap.addLayer(osm);
							mymap.setView([38.246242, 21.7350847], 16);
							var heat = L.heatLayer(response['lon']).addTo(mymap),
                            draw = true;

										
      },
		error: function(XMLHttpRequest, textStatus, errorThrown){
		   //console.log(response);
		   alert("Status: " + textStatus); alert("Error: " + errorThrown); 
		}
      });            

   

      });

	     });
