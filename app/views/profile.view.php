<?php
use app\controller\Profile;
$x = new Profile();
$x->connection(SERVER_NAME, USER_NAME, PASSWORD, DB_NAME);
$profile = $x->getUserByUsername($_SESSION['username']);
$profile_post = $x->getPostsByUsername($_SESSION['username']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Profile Page</title>
  <link rel="stylesheet" href="<?= ROOT ?>/public/assests/css/profile.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
  <nav class="navbar container">
    <a href="home" class="navbar-brand">Monstergram</a>
    <ul class="navbar-nav">
      <li><a class="logout-btn" href="CreatePost" class="nav-link">Create Post +</a></li>
      <li class="nav-item"><a href="profile" class="nav-link">Profile</a></li>
      <li class="nav-item"><a href="home" class="nav-link">Home</a></li>
      <li><a class="logout-btn" href="logout" class="nav-link">Logout</a></li>
    </ul>
  </nav>
  <div class="container">
    <div class="profile-header">
      <img src="<?php echo $profile['profile_img']; ?>" alt="Profile Picture">
      <div class="profile-info">
        <h1>
          <?php echo $_SESSION['username'] ?>
        </h1>
        <a class="btn" href="Update">Edit Profile</a>
      </div>
    </div>
    <p>Bio:
      <?php echo $profile['bio'] ?>
    </p>
    <h2 class="label">Posts:
      <?= count($profile_post); ?>
    </h2>
    <div class="post-grid">
      <?php
      $posts = $profile_post;
      foreach ($posts as $post):
        $x = $post['image_path'];
        ?>
        <div class="post" id="<?php echo $post['post_id'] ?>">
          <div class="edit-btn-div">
            <span class="user_name bold">
              <?php echo $post['user_name'] ?>
            </span>
            <img class="edit-btn" src="<?= ROOT ?>/public/assests/images/three_dot.png">
            <div class="post-menu">
              <button class="edit-post-btn" data-postid="<?php echo $post['post_id'] ?>">Edit Post</button>
              <button class="delete-post-btn" data-postid="<?php echo $post['post_id'] ?>">Delete Post</button>
            </div>
          </div>
          <div class="image-container">
            <img src="<?= $x ?>" alt="Post Image">
          </div>
          <p class="user_name">
            <span class="user_name">
              <?php echo $post['user_name'] ?>
            </span>
            <span class="content">
              <?php echo $post['content']; ?>
            </span>
          </p>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</body>
</html>
<script src="<?=ROOT?>/public/assests/javascript/profile.js"></script>