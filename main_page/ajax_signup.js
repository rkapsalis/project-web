$("signup-form").submit(function signup_check() { //μολις κανει signup
   var username = $("#usr").val();
   var pass = $("#pwd").val();
   var email = $("#mail").val();
   var password2 = $
    alert(username);
     if (username == "" || pass == "" || email == "") {
         alert("Something is missing")
     } else {
         $.ajax({
             type: 'post',
             url: 'signup.inc.php',
             data: {
                 email: mail,
                 username: username,
                 password: pass
             },
             success: function (response) {
                 if (response == "success") {  //επιστροφη στην αρχικη
                    alert("Successful signup!");
                   window.location.href = ".../index.html"
                 } else {
                     alert("Wrong Password or username.");
                 }
             }
         });
     }
 });
