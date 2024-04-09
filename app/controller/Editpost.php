<?php
namespace app\controller;
use app\core\Controller;
use app\models\Post;
use app\core\Config;
class Editpost extends Controller
{
  use Post;
  
  public function check()
  {
    new Config();
    if (isset($_POST['submit'])) {
      $currentUrl = $_SERVER['REQUEST_URI'];
      $urlParts = explode('/', $currentUrl);
      $postId = end($urlParts);
      $new_content = $_POST['description'];
      $this->connection(SERVER_NAME, USER_NAME, PASSWORD, DB_NAME);
      $this->UpdatePost($new_content, $postId);
    }
    $this->view('editpost');
  }
}