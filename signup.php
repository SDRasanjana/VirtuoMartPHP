<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>E- CommerceWebsite</title>
        <link rel="stylesheet" href="font-awesome-4.7.0/css/font-awesome.min.css"/>
        <link rel="stylesheet" type="text/css" href="stylelogin.css">
        <style>
          .message {
            color: green;
            font-weight: bold;
          }
          .error {
            color: red;
            font-weight: bold;
          }
          .container {
            max-width: 600px;
            margin: 0 auto;
        }
          
        </style>
     </head>
     <body>
     <div class="container">
     <div class="form-container">
        <form action="register.php" method="post">
            <div class="container">
              <h1>Sign Up</h1>
              <p>Please fill in this form to create an account.</p>
              <hr>
              <!--add username column-->
              <label for="username"><b>Username</b></label>
              <input type="text" placeholder="Enter Your Username" name="username" required>

              <label for="username"><b>Name</b></label>
              <input type="text" placeholder="Enter Your name" name="name" required>
          
              <label for="email"><b>Email</b></label>
              <input type="text" placeholder="Enter Email" name="email" required>
          
              <label for="psw"><b>Password</b></label>
              <input type="password" placeholder="Enter Password" name="password" required>
          
              <label for="psw-repeat"><b>Repeat Password</b></label>
              <input type="password" placeholder="Repeat Password" name="re_password" required>

              <div class="form-group">
                    <label for="phoneNo"><b>Phone Number</b></label>
                    <input type="text" placeholder="Enter Phone Number" name="phoneNo" required>
                </div>
                <div class="form-group">
                    <label for="gender"><b>Gender</b></label>
                    <select name="gender" required>
                        <option value="">Select Gender</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                        <option value="other">Other</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="address"><b>Address</b></label>
                    <input type="text" placeholder="Enter Address" name="address" required>
                </div>
                <div class="form-group">
                    <button type="submit">Sign Up</button>
                </div>
                <div class="form-group">
                    <p>Already have an account? <a href="login.php" style="color:#e4144d;">Login</a></p>
                    <div id="messageContainer"></div>
                </div>
            </form>
        </div>
      </div>

          <script>
            // Function to get URL parameter
            function getUrlParameter(name) {
                name = name.replace(/[\[]/, '\\[').replace(/[\]]/, '\\]');
                var regex = new RegExp('[\\?&]' + name + '=([^&#]*)');
                var results = regex.exec(location.search);
                return results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));
            }
    
            // Display the message if exists
            window.onload = function() {
                var message = getUrlParameter('message');
                var error = getUrlParameter('error');
                var messageContainer = document.getElementById('messageContainer');
                if (message) {
                     messageContainer.innerHTML = '<div class="message">' + message + '</div>';
                } else if (error) {
                    messageContainer.innerHTML = '<div class="error">' + error + '</div>';
                }
            }
        </script>
     </body>
</html>
