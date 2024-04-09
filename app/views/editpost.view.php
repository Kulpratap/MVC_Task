<?php
use app\controller\Editpost;


$currentUrl = $_SERVER['REQUEST_URI'];
$urlParts = explode('/', $currentUrl);
$postId = end($urlParts);
$editpost=new Editpost();
$editpost->connection(SERVER_NAME, USER_NAME, PASSWORD, DB_NAME);
$post=$editpost->readPost($postId);
$imagePath = ltrim($post['image_path'], '.');
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Update profile</title>
  <link rel="stylesheet" href="<?= ROOT ?>/public/assests/css/createpost.css">
</head>

<body>
  <div class="container">
    <div class="post-form">
      <h2>Edit Profile</h2>
      <form id="post-form" method="POST" enctype="multipart/form-data">
        <div class="form-group">
          <label for="image">Profile Image</label>
          <div class="container">
            <img class="image-show" src="<?php echo $imagePath?>" alt="profile-img">
          </div>
        </div>
        <div class="form-group">
          <label for="description">Edit Caption:</label>
          <textarea id="description" name="description"
            placeholder="Enter your Bio for your Profile here..." ><?php echo $post['content']?></textarea>
        </div>
        <input class="create_button" name="submit" type="submit" value="Edit Post" ></button>
    </div>
  </div>
</body>
</html>