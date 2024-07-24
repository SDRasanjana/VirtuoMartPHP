<?php
if(isset($_POST['submit'])){
  if(empty($_POST['name']) || empty($_POST['email']) || empty($_POST['subject']) || empty($_POST['message'])){
    $response = "All fields are required.";
  } else {
    $response = sendMail($_POST['email'], $_POST['subject'], $_POST['message']);
  }
   //Display or use $response here
  echo $response;
}
?>
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
    <form action="message.php" method="POST" enctype="multiper">
      <div class="dbl-field">
        <div class="field">
          <input type="text" name="name" placeholder="Enter your name" required>
          <i class='fas fa-user'></i>
        </div>
        <div class="field">
          <input type="text" name="email" placeholder="Enter your email" id="email" required>
          <i class='fas fa-envelope'></i>
        </div>
      </div>
      <div class="dbl-field">
        <div class="field">
          <input type="text" name="phone" placeholder="Enter your phone" required>
          <i class='fas fa-phone-alt'></i>
        </div>
        <div class="field">
          <input type="text" name="product" placeholder="Enter your product name"required>
          <i class='fas fa-globe'></i>
        </div>
      </div>
      <div class="message">
        <textarea placeholder="Write your message" name="message" required></textarea>
        <i class="material-icons"></i>
      </div>
      <div class="d-flex">
      <div class="button-area">
      <button class="btn btn-primary me-2" name="submit">Send Feedback</button>
      </div>
      </div>
      <?php 
      if(@$response == "success"){
        ?>
        <p class = "success"> Email send successfully</p>
        <?php
      }else{
        ?>
        <p class = "error"> <?php echo @$response; ?></p>
        <?php
      }
      ?>
    </form>
  </div>
</body>

</html>