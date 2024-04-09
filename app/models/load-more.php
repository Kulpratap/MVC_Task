<?php

class PostLoader
{
    private $conn;
    public function loadMorePosts($offset)
    {
        $this->conn = new mysqli("localhost", "kul", "Kul@123456", "USER");
        $sql = "SELECT P.post_id, P.user_name, P.content, P.image_path,P.like_count,  U.profile_img AS profile_img FROM posts P JOIN  users U ON P.user_name = U.UserName ORDER BY P.created_at DESC LIMIT ?, 10";

        // Prepare the statement
        $stmt = $this->conn->prepare($sql);
        // Bind parameters
        $stmt->bind_param("i", $offset);
        $stmt->execute();
        $result = $stmt->get_result();
        $posts = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return json_encode($posts);
    }
}
$postLoader = new PostLoader();
if (isset($_GET['offset']) && is_numeric($_GET['offset'])) {
    $offset = $_GET['offset'];
    $posts = $postLoader->loadMorePosts($offset);
    echo $posts;
} else {
    echo json_encode(["error" => "Invalid offset"]);
}