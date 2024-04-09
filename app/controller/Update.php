<?php
namespace app\controller;
use app\core\Controller;
use app\models\Profiledb;
use app\models\User;
use app\core\Config;
class Update extends Controller
{
  use User,Profiledb;
  public function check()
  {
    new Config();
    if (isset($_POST['submit'])) {
      $bio = $_POST['description'];
      $email = trim($_POST['email']);
      $new_username = $_POST['username'];
      $new_username=trim($new_username);
      $filename = $_FILES["filetoupload"]["name"];
      $tempname = $_FILES["filetoupload"]["tmp_name"];
      $folder = "../images/" . $filename;
      move_uploaded_file($tempname, $folder);
      $this->connection(SERVER_NAME, USER_NAME, PASSWORD, DB_NAME);
      if ($filename == '') {
        $folder = '';
      }
      $email = $_POST['email'];
      $user_name = $_SESSION['username'];
      $isvalid = $this->emailValidate($email);
      if ($isvalid == true) {
        $valid_Email = $this->checkAndUpdateEmail($email, $user_name);
      } else {
        echo "<script>alert('Email is not valid'); window.location.href='update'; </script>";
      }
      $new_user_name = $_POST['username'];
      if ($new_user_name == '') {
        echo "<script>alert('Username cannot be empty'); window.location.href='update'; </script>";
      } else {
        $user_name = $_SESSION['username'];
        $valid_User = $this->checkAndUpdateUsername($new_user_name, $user_name);
      }

      if ($valid_Email == true && $valid_User == true) {
        $this->UpdateProfile($bio, $folder);
      } else if ($valid_Email == true && $valid_User == false) {
        echo "<script>alert('$valid_User'); window.location.href='profile';</script>";
      } else if ($valid_Email == false && $valid_User == true) {
        echo "<script>alert('$valid_Email'); window.location.href='profile';</script>";
      }
    }
    if ($_SESSION['loggedin'] == true) {
      $this->view('editprofile');
    } else {
      $this->view('404');
    }

  }
}