<?php
namespace app\controller;

use app\core\Controller;
use app\models\Post;
use app\core\Config;

class CreatePost extends Controller
{
  use Post;
  public function check()
  {
    new Config();
    if (isset($_POST['submit'])) {
      $content = $_POST['description'];
      if ($_FILES['filetoupload']['error'] === UPLOAD_ERR_OK) {
        $filename = $_FILES["filetoupload"]["name"];
        $tempname = $_FILES["filetoupload"]["tmp_name"];
        $folder = "../images/" . $filename;
        move_uploaded_file($tempname, $folder);
        $this->connection(SERVER_NAME, USER_NAME, PASSWORD, DB_NAME);
        $this->createPost($content, $folder);
      } else {
        echo "<p style='color:red;'>Error: Please upload an image.</p>";
      }
    }
    if ($_SESSION['loggedin'] == true) {
      $this->view('createpost');
    } else {
      $this->view('404');
    }

  }
}