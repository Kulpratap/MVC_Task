<?php
session_start();
class CommentController
{
    private $conn;
    public function insertComment($postId, $commentText)
    {
        $this->conn = new mysqli("localhost", "kul", "Kul@123456", "USER");
        // Prepare the SQL statement
        $stmt = $this->conn->prepare("INSERT INTO comments (post_id, comment_content,commenter_name) VALUES (?, ?,?)");
        $stmt->bind_param("iss", $postId, $commentText, $_SESSION['username']);
        if ($stmt->execute()) {
            // Comment insertion successful
            echo json_encode(array('success' => true));
        } else {
            echo json_encode(array('success' => false, 'error' => 'Failed to insert comment'));
        }
    }
}

// Check if the request is a POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $postId = $_POST['postId'];
    $commentText = $_POST['commentText'];
    $commentController = new CommentController();
    $commentController->insertComment($postId, $commentText);
} else {
    // Invalid request method
    echo json_encode(array('success' => false, 'error' => 'Invalid request method'));
}
?>