<?php
$_SESSION['loggedin']=false;
?>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link rel="stylesheet" href="<?=ROOT?>/public/assests/css/styles.css">
</head>

<body>
  <div class="container"> <!-- Container to center the form -->
    <form method="POST"  id="myForm" class="form">
      <h2>Login </h2>
      <div class="form-group">
        <label for="fname">Username:</label>
        <input type="text" name="username" id="username" placeholder="Enter your Username" required>
      </div>
      <div class="form-group">
        <label for="password">Password</label>
        <input type="password" name="password" id="password" placeholder="Enter your password" required><span><img src="<?=ROOT?>/public/assests/images/images.png" onclick="myFunction()" height='20px'></span>
      </div>
      <div class="form-group">
        <input type="submit" name="login" value="Login"><br><br>
        </span><a class="link google-login" href="<?=ROOT?>/public/googlelogin">Login With Google</a><br><br>
        <span>Not a USER?....</span><a class="link" href="<?=ROOT?>/public/signup">Sign Up</a>
        <a class="link" href="<?=ROOT?>/public/forgotpassword">Forgot Password</a>
      </div>
    </form>
  </div>
    <!-- <script src="../Javascript/script.js"></script> -->
</body>
</head>
</html>