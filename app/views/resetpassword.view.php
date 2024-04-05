<?php
if (isset($_GET['token'])) {
  $_SESSION['token'] = $_GET['token'];
}
  // Connect to the database.
  $conn = new mysqli("localhost", "kul", "Kul@123456", "USER");

  // Check connection.
  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  }
  // Get the current time in GMT (UTC).
  $current_time_utc = gmdate('Y-m-d H:i:s');
  $token=$_SESSION['token'];
  // Prepare SQL statement to check if the token exists, matches, and is still valid.
  $sql = "SELECT token FROM users WHERE token = ? AND token = ? AND expire_time > ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("sss", $token, $token, $current_time_utc);
  $stmt->execute();
  $result = $stmt->get_result();
  // Check if any rows were returned.
  $x=($result->fetch_assoc());
  if ($x["token"]!=$_SESSION['token'] || $_SESSION['token']==null) {
    echo "<h1>Link expires</h1>";
  } else{ ?>
    <!DOCTYPE html>
    <html lang="en">
    
    <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Document</title>
      <link rel="stylesheet" href="<?=ROOT?>/public/assests/css/styles.css"> <!-- Link to external CSS file -->
    </head>
    
    <body>
      <div class="container"> <!-- Container to center the form -->
        <form method="POST"   id="myForm" class="form">
          <h2>Update password </h2>
          <div class="form-group">
            <label for="password">enter new password</label>
            <input type="password" name="password" id="password" required>
          </div>
          <div class="form-group">
            <label for="confirm_password">confirm new password</label>
            <input type="password" name="confirm_password" id="confirm_password" required>
          </div>
          <div class="form-group">
          <input type="submit" name="submit" value="Change Password"><br><br>
        </form>
    </body>
    </head>
    
    </html>
    <?php
  }
?>
