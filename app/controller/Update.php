<?php
$model = new Model;
$model->test('Profiledb');
$model->test('User');
class Update extends Controller
{
  use User,Profiledb;
  public function check()
  {
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
        $x = $this->checkAndUpdateEmail($email, $user_name);
      } else {
        echo "<script>alert('Email is not valid'); window.location.href='update'; </script>";
      }
      $new_user_name = $_POST['username'];
      if ($new_user_name == '') {
        echo "<script>alert('Username cannot be empty'); window.location.href='update'; </script>";
      } else {
        $user_name = $_SESSION['username'];
        $y = $this->checkAndUpdateUsername($new_user_name, $user_name);
      }

      if ($x == true && $y == true) {
        $this->UpdateProfile($bio, $folder);
      } else if ($x == true && $y == false) {
        echo "<script>alert('$y'); window.location.href='profile';</script>";
      } else if ($x == false && $y == true) {
        echo "<script>alert('$x'); window.location.href='profile';</script>";
      }
    }
    if ($_SESSION['loggedin'] == true) {
      $this->view('editprofile');
    } else {
      $this->view('404');
    }

  }
}