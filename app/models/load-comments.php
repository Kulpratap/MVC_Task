<?php
class CommentModel
{
  private $conn;
  public function getCommentsByPostId($postId)
  {
    $this->conn = new mysqli("localhost", "kul", "Kul@123456", "USER");

    $stmt = $this->conn->prepare('SELECT * FROM comments WHERE post_id = ? ORDER BY comment_date');
    $stmt->bind_param('i', $postId);
    $stmt->execute();
    $result = $stmt->get_result();
    $comments = $result->fetch_all(MYSQLI_ASSOC);
    return $comments;
  }
}

if (isset($_GET['postId'])) {
  $commentModel = new CommentModel();
  $postId = $_GET['postId'];
  $comments = $commentModel->getCommentsByPostId($postId);
  echo json_encode($comments);
} else {
  echo json_encode(array('error' => 'Post ID not provided'));
}
?>