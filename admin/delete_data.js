$(document).ready(function() {
    //var $sel = jQuery('#monthsince').val();

    $(".button").click(function() {        
            
        $('.confirmation-popup-container').toggleClass('is-visible');         
       
        $('.doAction').click(function() { //delete button

            $.ajax({ //create an ajax request to display.php
                type: "POST",
                url: "delete_data.inc.php",
                data: '',
                dataType: "text",
                success: function(response) {
                    console.log(response);
                    if (response == "success") {
                        alert("Data have been successfully deleted from database.");
                    } else {
                        alert("An error occurred. Please try again.");
                    }

                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    // console.log(response);
                    alert("Status: " + textStatus);
                    alert("Error: " + errorThrown);
                }
            });

            $(this).parents('.confirmation-popup-container').fadeOut(500, function() {
                $(this).remove();
            });
        });


        $('.cancelAction, .fa-close').click(function() { //cancel and close button
            $(this).parents('.confirmation-popup-container').fadeOut(500, function() {
                $(this).removeClass('is-visible');
                 $(this).css("display", "");
            });
        });


    });

});