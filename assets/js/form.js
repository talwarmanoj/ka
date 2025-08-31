// form.js
$(document).ready(function () {
    $("#registrationForm").submit(function (e) {
      e.preventDefault();
  
      const name = $("#name").val().trim();
      const email = $("#email").val().trim();
      const password = $("#password").val();
      const confirmPassword = $("#c_password").val();
  
      const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      const passwordPattern = /^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/;
  
      if (!name || !email || !password || !confirmPassword) {
        showMessage("All fields are required.", "red");
        return;
      }
  
      if (!emailPattern.test(email)) {
        showMessage("Invalid email format.", "red");
        return;
      }
  
      if (!passwordPattern.test(password)) {
        showMessage("Password must be at least 8 characters long and include uppercase, lowercase, number, and special character.", "red");
        return;
      }
  
      if (password !== confirmPassword) {
        showMessage("Passwords do not match.", "red");
        return;
      }
  
      // AJAX call
      $.ajax({
        url: "user-signup-process.php",
        type: "POST",
        data: { name, email, password, confirmPassword },
        success: function (response) {
            //document.querySelector('#message').scrollIntoView({behavior: 'smooth'});
            showMessage(response, "green");
            //$("#registrationForm")[0].reset();
        },
        error: function () {
            showMessage("An error occurred.", "red");
        },
      });
    });
  
    function showMessage(message, color) {
        $("#message").html(message).css("color", color);

        setTimeout(() => {
            $("#message").html('');
        }, "4000");
        
    }
  });
  