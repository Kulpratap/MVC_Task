<?php
namespace app\models;
use app\core\Database;
trait Post
{
  use Database;
  public function createPost($content, $image_path)
  {
    $user_name = $_SESSION['username'];
    $this->conn->begin_transaction();
    $sql = "INSERT INTO posts (user_name,content, image_path) VALUES ('$user_name','$content', '$image_path')";
    try {
      // Execute queries
      $query = $this->conn->query($sql);
      // Check if all queries were successful
      if ($query) {
        // Commit transaction
        $this->conn->commit();
        header('Location:home');
      } else {
        // Rollback transaction
        $this->conn->rollback();
        echo $this->conn->error;
      }
    } catch (\mysqli_sql_exception $e) {
      $this->conn->rollback();
      echo $e->getMessage();
    }
  }
  public function readPost($postId){
    $sql = "SELECT image_path,content FROM posts where post_id=$postId";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();
    $posts = $result->fetch_assoc();
    $stmt->close();
    return $posts;
  }
  public function UpdatePost($content,$postId){
    $sql = "UPDATE  posts SET content='$content' where post_id=$postId" ;
    
      $query = $this->conn->query($sql);
      // Check if all queries were successful
      if ($query) {
        // Commit transaction
        header('Location:/public/profile');
      } 
  }
  public function displayPosts($posts)
  {
    foreach ($posts as $post):
      $profile = $this->getUserByUsername($post['user_name']); ?>
      <div class="post" data-post-id="<?php $post['post_id'] ?>">
        <div class="img-div">
          <?php $y = $profile['profile_img']; ?>
          <div class="image-container">
            <img class="profile-image" src="<?= $y ?>" alt="profile-img">
          </div>
          <p class="post_head">
            <?= $post['user_name'] ?>
          </p>
          <div class="edit-btn-div">
            <button class="edit-post-btn">Edit Post</button>
          </div>
        </div>
        <div class="post_content">
          <?php $x = $post['image_path']; ?>
          <img class="post-image" src="<?= $x ?>" alt="Post Image">
          <p class="user_name">
            <span class="user_name">
              <?= $post['user_name'] ?>
            </span>
            <span class="content">
              <?= $post['content']; ?>
            </span>
          </p>
        </div>
        <div class="reactions">
          <a href="#" id="like-btn<?php echo $post['post_id']; ?>"><i class="fa-regular fa-thumbs-up" id ="like-button-i<?php echo $post['post_id']; ?>"></i></a>
          <span class="like-count-container">
            <span class="like-count">
              <?php echo $post['like_count']; ?>
            </span> Likes
          </span>
          <a href="#" id="comment-btn<?php echo $post['post_id']; ?>"><i class="fa-regular fa-comment"></i></a>
          <div class="comment-container<?php echo $post['post_id'] ?> commentbox">
            <h1>this is my comment</h1>
          </div>
        </div>

      </div>
    <?php endforeach;
  }
}