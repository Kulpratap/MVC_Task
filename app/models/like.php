<?php
session_start();
class LikeUpdate
{   
    private $conn;
    public function toggle_like($postId, $username) {
        $this->conn = new mysqli("localhost", "kul", "Kul@123456", "USER");
        
        // Check if the user has already liked the post
        $checkQuery = "SELECT * FROM likes WHERE post_id = $postId AND user_name = '$username'";
        $checkResult = $this->conn->query($checkQuery);
        
        if ($checkResult->num_rows > 0) {
            $_SESSION['liked']=false;
            // User has already liked the post, so delete the like record
            $query = "DELETE FROM likes WHERE post_id = $postId AND user_name = '$username'";
            $query1="UPDATE posts SET like_count=like_count-1 where post_id=$postId";
        } else {
            // User has not liked the post, so insert a new like record
            $_SESSION['liked']=true;
            $query = "INSERT INTO likes (post_id, user_name,like_status) VALUES ($postId, '$username','liked')";
            $query1="UPDATE posts SET like_count = like_count+1 where post_id=$postId";
        }
        
        if ($this->conn->query($query) && $this->conn->query($query1)) {
            // Get the updated like count for the post
            $likeCountQuery = "SELECT COUNT(*) AS like_count FROM likes WHERE post_id = $postId";
            $result = $this->conn->query($likeCountQuery);
            $row = $result->fetch_assoc();
            return $row['like_count'];
        } else {
            return -1;
        }
    }
}

$likeUpdate = new LikeUpdate();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['post_id'])) {
        $postId = $_POST['post_id'];
        $username = $_SESSION['username'];
        $likeCount = $likeUpdate->toggle_like($postId, $username);
        $response = [
            'post_id' => $postId,
            'likes' => $likeCount,
            'like_status'=>$_SESSION['liked']
        ];
        header('Content-Type: application/json');
        echo json_encode($response);
    }
} else {
    echo json_encode(["error" => "Invalid"]);
}
?>
