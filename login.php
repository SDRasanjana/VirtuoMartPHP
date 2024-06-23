<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>E- CommerceWebsite</title>
        <link rel="stylesheet" href="font-awesome-4.7.0/css/font-awesome.min.css"/>
        <link rel="stylesheet" type="text/css" href="css/stylelogin.css">
     </head>
     <body>
        <form action="register.php" style="border:1px solid #ccc">
            <div class="container">
              <h1>Sign Up</h1>
              <p>Please fill in this form to create an account.</p>
              <hr>
              <!--add username column-->
              <label for="username"><b>Username</b></label>
              <input type="text" placeholder="Enter Your Username" name="username" required>
          
              <label for="email"><b>Email</b></label>
              <input type="text" placeholder="Enter Email" name="email" required>
          
              <label for="psw"><b>Password</b></label>
              <input type="password" placeholder="Enter Password" name="password" required>
          
              <label for="psw-repeat"><b>Repeat Password</b></label>
              <input type="password" placeholder="Repeat Password" name="re_password" required>
          
              <label>
                <input type="checkbox" checked="checked" name="remember" style="margin-bottom:15px"> Remember me
              </label>
          
              <p>By creating an account you agree to our <a href="#" style="color:dodgerblue">Terms & Privacy</a>.</p>
              <p>Do you have an account?  <a href="login2.html" style="color:dodgerblue">Login</a>.</p>
          
              <div class="clearfix">
                <button type="button" class="cancelbtn">Cancel</button>
                <button type="submit" class="signupbtn">Sign Up</button>
              </div>
              <!--add message coantainer to display the error/msg when register to the system-->
              <div id="messageContainer"></div>
            </div>
          </form>

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
                if (message) {
                    var messageContainer = document.getElementById('messageContainer');
                    messageContainer.innerHTML = '<div class="' + (message.includes('successfully') ? 'message' : 'error') + '">' + message + '</div>';
                }
            }
        </script>
     </body>
</html>
