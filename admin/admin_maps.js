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
            // for ($i = 0; $i < response['activities'].length; $i++){
            //     $("#activity1").append(" <option value= " + response['activities'][$i] + ">" + response['activities'][$i] + "</option>");
            // }
            for ($i = 0; $i < response['activities'].length; $i++){
                // $("#activity2").append(" <option value= " + response['activities'][$i] + ">" + response['activities'][$i] + "</option>");

                $(".dropdown-list").append("<label class='dropdown-option'> <input type='checkbox' name='dropdown-group' value=" + response['activities'][$i] + ">" + response['activities'][$i] + " </label>");
     
     
            }

			$(function(){
			    var $select = $("#minutessince");
			    var $select1 = $("#minutesuntil");
			    for (i=0;i<=59;i++){
			    	if(i<10){ //with leading zeros
			    		j= "0" + i;
			    		 $select.append($('<option></option>').val(j).html(j))
				         $select1.append($('<option></option>').val(j).html(j))

			    	}
			    	else{
				        $select.append($('<option></option>').val(i).html(i))
				        $select1.append($('<option></option>').val(i).html(i))
			        }
			    }
			});
			
			(function($) {
  var CheckboxDropdown = function(el) {
    var _this = this;
    this.isOpen = false;
    this.areAllChecked = false;
    this.$el = $(el);
    this.$label = this.$el.find('.dropdown-label');
    this.$checkAll = this.$el.find('[data-toggle="check-all"]').first();
    this.$inputs = this.$el.find('[type="checkbox"]');
    
    this.onCheckBox();
    
    this.$label.on('click', function(e) {
      e.preventDefault();
      _this.toggleOpen();
    });
    
    this.$checkAll.on('click', function(e) {
      e.preventDefault();
      _this.onCheckAll();
    });
    
    this.$inputs.on('change', function(e) {
      _this.onCheckBox();
    });
  };
  
  CheckboxDropdown.prototype.onCheckBox = function() {
    this.updateStatus();
  };
  
  CheckboxDropdown.prototype.updateStatus = function() {
    var checked = this.$el.find(':checked');
    
    this.areAllChecked = false;
    this.$checkAll.html('Check All');
    
    if(checked.length <= 0) {
      this.$label.html('Select Activities');
    }
    else if(checked.length === 1) {
      this.$label.html(checked.parent('label').text());
    }
    else if(checked.length === this.$inputs.length) {
      this.$label.html('All Selected');
      this.areAllChecked = true;
      this.$checkAll.html('Uncheck All');
    }
    else {
      this.$label.html(checked.length + ' Selected');
    }
  };
  
  CheckboxDropdown.prototype.onCheckAll = function(checkAll) {
    if(!this.areAllChecked || checkAll) {
      this.areAllChecked = true;
      this.$checkAll.html('Uncheck All');
      this.$inputs.prop('checked', true);
    }
    else {
      this.areAllChecked = false;
      this.$checkAll.html('Check All');
      this.$inputs.prop('checked', false);
    }
    
    this.updateStatus();
  };
  
  CheckboxDropdown.prototype.toggleOpen = function(forceOpen) {
    var _this = this;
    
    if(!this.isOpen || forceOpen) {
       this.isOpen = true;
       this.$el.addClass('on');
      $(document).on('click', function(e) {
        if(!$(e.target).closest('[data-control]').length) {
         _this.toggleOpen();
        }
      });
    }
    else {
      this.isOpen = false;
      this.$el.removeClass('on');
      $(document).off('click');
    }
  };
  
  var checkboxesDropdowns = document.querySelectorAll('[data-control="checkbox-dropdown"]');
  for(var i = 0, length = checkboxesDropdowns.length; i < length; i++) {
    new CheckboxDropdown(checkboxesDropdowns[i]);
  }
})(jQuery);
		




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
        	// var $activity1 = jQuery('#activity1').val();
        	// var $activity2 = jQuery('#activity2').val();
        	var $daysince = jQuery('#daysince').val();
        	var $dayuntil = jQuery('#dayuntil').val();
        	var $hoursince = jQuery('#hoursince').val();
        	var $houruntil = jQuery('#houruntil').val();
        	var $minutessince = jQuery('#minutessince').val();
        	var $minutesuntil = jQuery('#minutesuntil').val();
            var $am_pm = jQuery('#am-pm').val();
        	var $am_pm2 = jQuery('#am-pm2').val();
            var selected = [];
				$('.dropdown-list input:checked').each(function() {
				    selected.push($(this).attr('value'));
				});


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
		        	// activity1: $activity1,
		        	// activity2: $activity2,
		        	selected: selected,
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
