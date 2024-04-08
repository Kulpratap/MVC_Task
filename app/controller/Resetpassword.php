<?php
// $model = new Model;
// $model->test('User');
namespace app\controller;
use app\core\Controller;
use app\models\User;
use app\core\Config;
class Resetpassword  extends Controller{
 
  use User;
  
  public function check(){
    new Config();
    if (isset($_POST['submit'])) {
      // Create an instance of the Database class
      $this->connection(SERVER_NAME, USER_NAME, PASSWORD, DB_NAME);
      // Get form data
      $password = $_POST["password"];
      $confirm_passowrd = $_POST['confirm_password'];
    
      if ($password != $confirm_passowrd) {
        echo "<script>alert('password not same');  window.location.href ='resetpassword';</script>";
      }
      $email = $this->getEmailFromToken($_SESSION['token']);
      $this->UpdateData($_SESSION['token'], $password);
      $this->tokennull($email);
      // Close the database connection
      $this->closeConnection();
    }
    
    $this->view('resetpassword');
  }
}