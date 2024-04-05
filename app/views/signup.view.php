<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registration</title>
  <link rel="stylesheet" href="<?=ROOT?>/public/assests/css/styles.css">
</head>
<body>
  <div class="container">
    <form method="POST" action="" id="myForm" class="form">
      <h2>Sign Up </h2>
      <div class="form-group">
        <label for="fname">Enter your Username:</label>
        <input type="text" name="username" id="username" placeholder="Your Username" required>
      </div>
      <div class="form-group">
        <label for="password">enter password</label>
        <input type="password" name="password" id="password" placeholder="Enter your password"required><span><img src="<?=ROOT?>/public/assests/images/images.png" onclick="myFunction()" height='20px'></span>
      </div>
      <div class="form-group">
        <label for="confirm_password">confirm password</label>
        <input type="password" name="confirm_password" id="confirm_password" placeholder="Enter your password" required><span><img src="<?=ROOT?>/public/assests/images/images.png" onclick="myFunction()" height='20px'></span>
      </div>
      <div class="form-group">
        <label for="mail">Enter your mail</label>
        <input type="text" name="mail" id="mail" placeholder="Enter Your Mail" required>
      </div>
      <div class="form-group">
      <input type="submit" value="Register" name="register"><br><br>
      <span>Already a USER?....</span><a  class="link" href="<?=ROOT?>/public/login">Login</a>
    </div>
    <?php ?>
    </form>
</body>
</head>

</html>