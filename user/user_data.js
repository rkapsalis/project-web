 $(document).ready(function() {
              

      $.ajax({    //create an ajax request to display.php
        type: "POST",
        url: "user_data.inc.php", 
                  
        dataType: "json",                   
        success: function(response){       
            console.log(response);		
            //response = JSON.parse(response);
            //$('.html').append("<div class='new' id='" + id + "'>jitender</div>");
			$('.welcome').append(" <h3>Welcome back, <br />" + response["name"] + "!</h3>");
            $(".pill_date").text("" + response["month"] + "" + response["year"]);			
            $("#my_eco").text(response["score"] + "%");
			$("#range").text("" + response["min_date"] + " - " + response["max_date"]);
			$("#last_up").text(response["upload"]);
            $("#range").text(response["id"]);
			
			annual(response["months"]);
            //1st		
            console.log(response["lead"][3]["name"]);				
			if ('0' in response["lead"]) {$("#one").text("" + response["lead"][0]["name"] + "  " + response["lead"][0]["surname"] + ".");}
			if ('0' in response["lead"]){$("#score_one").text("" + response["lead"][0]["score"] + "%");}
			//2nd
			if ('1' in response["lead"]){$("#two").text("" + response["lead"][1]["name"] + "  " + response["lead"][1]["surname"]+ ".");}
			if ('1' in response["lead"]){$("#score_two").text("" + response["lead"][1]["score"] + "%");}
			//3rd
			if ('2' in response["lead"]){$("#three").text("" + response["lead"][2]["name"] + "  " + response["lead"][2]["surname"]+ ".");}
			if ('2' in response["lead"]){$("#score_three").text("" + response["lead"][2]["score"] + "%");}
			//user
			$("#my_name").text("" + response["lead"][3]["name"] + "  " + response["lead"][3]["surname"] + ".");
			$("#my_rank").text("Position: " + response["lead"][3]["rank"] + "");
			$("#my_score").text("" + response["lead"][3]["score"] + "%");			
			
			
        },
		error: function(XMLHttpRequest, textStatus, errorThrown){
		   console.log(response);
		   alert("Status: " + textStatus); alert("Error: " + errorThrown); 
		}
      });

	
//annual chart
function annual(months) {
var ctx = document.getElementById('annual');	
var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
        datasets: [{
            label: 'eco-score',
            data:   months,
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
        responsive:true,
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
}
});