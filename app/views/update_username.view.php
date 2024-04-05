<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="<?= ROOT ?>/public/assests/css/styles.css">
  <title>Update Username</title>
</head>

<body>
<div class="container"> <!-- Container to center the form -->
    <form method="POST"  id="myForm" class="form">
      <h2>Update Username </h2>
      <div class="form-group">
        <label for="email">Enter Username</label>
        <input type="text" name="new_username" placeholder="Enter Usename.." required>
      </div>
      <div class="form-group">
        <input type="submit" name="submit" value="Update Username"><br><br>
      </div>
    </form>
  </div>
</body>

</html>