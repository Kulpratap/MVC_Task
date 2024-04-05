<?php
$model = new Model;
$model->test('User');
class Signup extends Controller
{
  use User;
  public function check()
  {
    if (isset ($_POST['register'])) {
      $this->connection(SERVER_NAME, USER_NAME, PASSWORD, DB_NAME);
      // Get form data
      $username = $_POST["username"];
      $password = $_POST["password"];
      $confirm_passowrd = $_POST['confirm_password'];

      $password_hashed = password_hash($password, PASSWORD_DEFAULT);

      if ($password != $confirm_passowrd) {
        echo '<p style="color:red">Passowrd is not same</p>';
        exit;
      }
      $email = $_POST['mail'];
      if ($this->emailValidate($email) == true) {
       $result = $this->insertUserData($username, $email, $password_hashed);
      } else {
        "<script>alert('Email not valid');  window.location.href ='signup';</script>";
      }
      // Output the result
      if($result=='Registered Sucessfully'){
        echo "<script>alert('Registered Sucessfully');  window.location.href ='login';</script>";
      }else{
        echo "<script>alert('$result');  window.location.href ='signup';</script>";
      }
      
      // Close the database connection
      $this->closeConnection();
    }
    if($_SESSION['loggedin']==false){
    $this->view('signup');
    }else{
      header("Location:home");
    }
  }
}