<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>E-Commerce Website</title>
    <link rel="stylesheet" href="font-awesome-4.7.0/css/font-awesome.min.css" />
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
        }

        .container {
            padding: 16px;
        }

        .form-container {
            max-width: 400px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        input[type=text],
        input[type=email],
        input[type=password] {
            width: 100%;
            padding: 12px 20px;
            margin: 8px 0;
            display: inline-block;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        button {
            background-color: #04AA6D;
            color: white;
            padding: 14px 20px;
            margin: 8px 0;
            border: none;
            cursor: pointer;
            width: 100%;
            border-radius: 4px;
        }

        button:hover {
            opacity: 0.8;
        }

        .cancelbtn {
            width: auto;
            padding: 10px 18px;
            background-color: #f44336;
            border-radius: 4px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .error, .success {
            padding: 10px;
            background: #f1f1f1;
            margin-bottom: 20px;
            border-radius: 4px;
        }

        .page-banner {
            background-color: #444;
            padding: 60px 0;
            text-align: center;
            color: white;
            margin-bottom: 20px;
        }

        .page-banner h1 {
            margin: 0;
        }

        @media screen and (max-width: 300px) {
            .cancelbtn {
                width: 100%;
            }
        }
    </style>
</head>

<body>

    <div class="page-banner" style="background-image: url('assets/uploads/banner_login.jpg');">
        <div class="inner">
            <h1>Login</h1>
        </div>
    </div>

    <div class="container">
        <div class="form-container">
            <form action="login_process.php" method="post">
                <div class="form-group">
                    <label for="uname"><b>Username</b></label>
                    <input type="text" placeholder="Enter Username" name="username" required>
                </div>
                <div class="form-group">
                    <label for="psw"><b>Password</b></label>
                    <input type="password" placeholder="Enter Password" name="password" required>
                </div>
                
                <div class="form-group">
                    <button type="submit">Login</button>
                </div>
                <div class="form-group">
                    <input type="checkbox" checked="checked" name="remember"> Remember me
                </div>
                <div class="form-group">
                    <a href="forget-password.php" style="color:#e4144d;">Forgot password?</a>
                </div>
                <div class="form-group">
                    <p>Don't have an account? <a href="signup.php" style="color:#e4144d;">Sign up</a></p>
                </div>
                <div id="messageContainer"></div>
            </form>
        </div>
    </div>
    <script>
        window.onload = function() {
        var error = getUrlParameter('error');
        if (error) {
            var messageContainer = document.getElementById('messageContainer');
            messageContainer.innerHTML = '<div class="error">' + error + '</div>';
         }
    }
    </script>

</body>

</html>
