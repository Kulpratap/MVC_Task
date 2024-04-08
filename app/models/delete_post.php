<?php

if (isset($_POST['post_id'])) {
    $postId = $_POST['post_id'];
    $conn = new mysqli("localhost", "kul", "Kul@123456", "USER");
    // Perform the delete operation in your database
    $sql = "DELETE FROM posts WHERE post_id = $postId";
    $conn->query($sql);
    echo 'Post deleted successfully.';
} else {
    http_response_code(400);
    echo 'Post ID is required.';
}
?>
