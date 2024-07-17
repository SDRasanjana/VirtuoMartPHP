<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Feedback Form</title>
  <link rel="stylesheet" href="feedbackstyle.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
</head>

<body>
  <div class="wrapper">
    <header>Send us a Feedback</header>
    <form action="#" onsubmit="sendEmail(); reset(); return false;">
      <div class="dbl-field">
        <div class="field">
          <input type="text" name="name" placeholder="Enter your name">
          <i class='fas fa-user'></i>
        </div>
        <div class="field">
          <input type="text" name="email" placeholder="Enter your email" id="email">
          <i class='fas fa-envelope'></i>
        </div>
      </div>
      <div class="dbl-field">
        <div class="field">
          <input type="text" name="phone" placeholder="Enter your phone">
          <i class='fas fa-phone-alt'></i>
        </div>
        <div class="field">
          <input type="text" name="product" placeholder="Enter your product name">
          <i class='fas fa-globe'></i>
        </div>
      </div>
      <div class="message">
        <textarea placeholder="Write your message" name="message"></textarea>
        <i class="material-icons"></i>
      </div>
      <div class="button-area">
        <button type="submit">Send Feedback</button>
        <span></span>
      </div>
    </form>
  </div>
  <!--<script src="fbscript.js"></script>-->
  <script src=" https://smtpjs.com/v3/smtp.js"></script>
  <script>
    function sendEmail() {
      Email.send({
        Host: "smtp.gmail.com",
        Username: "dilarasanja5@gmail.com",
        Password: "123dilhan123",
        To: 'them@website.com',
        From: document.getElementById("email").value,
        Subject: "New Feedback Form",
        Body: "And this is the body"
      }).then(
        message => alert(message)
      );
    }
  </script>
</body>

</html>