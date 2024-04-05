<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="<?= ROOT ?>/public/assests/css/styles.css">
  <title>Update Email</title>
</head>

<body>
<div class="container"> <!-- Container to center the form -->
    <form method="POST"  id="myForm" class="form">
      <h2>Update Email </h2>
      <div class="form-group">
        <label for="email">Enter Email</label>
        <input type="text" name="email" id="password" value="hello" placeholder="Enter Email" required>
      </div>
      <div class="form-group">
        <input type="submit" name="submit" value="Update Email"><br><br>
      </div>
    </form>
  </div>
</body>

</html>