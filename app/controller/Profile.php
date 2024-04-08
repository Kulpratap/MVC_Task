<?php
// $model = new Model;
// $model->test('User');
// $model->test('Profiledb');
namespace app\controller;
use app\core\Controller;
use app\models\Profiledb;
use app\models\User;
use app\core\Config;
class Profile extends Controller
{
  use Profiledb, User;
  public function check()
  {
    new Config();
    $this->connection(SERVER_NAME, USER_NAME, PASSWORD, DB_NAME);
    $profile = $this->getUserByUsername($_SESSION['username']);
    $profile_posts = $this->getPostsByUsername($_SESSION['username']);
    $_SESSION['profile'] = $profile;
    $_SESSION['profile_posts'] = $profile_posts;
    if ($_SESSION['loggedin'] == true) {
      $this->view('profile');
    } else {
      header("Location:login");
    }
  }
}