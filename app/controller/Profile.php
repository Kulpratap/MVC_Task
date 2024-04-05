<?php
$model = new Model;
$model->test('Profiledb');
$model->test('User');
class Profile  extends Controller{
  use Profiledb,User;
   public function check(){
    $this->connection(SERVER_NAME, USER_NAME, PASSWORD, DB_NAME);
    $profile = $this->getUserByUsername($_SESSION['username']);
    $profile_posts=$this->getPostsByUsername($_SESSION['username']);
    $_SESSION['profile']=$profile;
    $_SESSION['profile_posts']=$profile_posts;
     if ($_SESSION['loggedin'] == true) {
      $this->view('profile');
    } else {
     header("Location:login");
    }
   }
 }