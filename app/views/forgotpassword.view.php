<?php
use app\core\Config;
new Config();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Forgot Password</title>
  <link rel="stylesheet" href="<?=ROOT?>/public/assests/css/styles.css">
</head>

<body>
  <div class="container"> <!-- Container to center the form -->
    <form method="POST" action="" id="myForm" class="form">
      <h2>Reset Password </h2>
      <div class="form-group">
        <label for="fname">Enter your mail</label>
        <input type="text" name="mail" id="mail" placeholder="Enter Your Mail" required>
      </div>
      <div class="form-group">
      <input type="submit" name="submit" value="Send Mail"><br><br>
      <a class="link" href="<?=ROOT?>/public/signup">Sign Up</a>
      </div>
    </form>
</body>
</head>
</html>