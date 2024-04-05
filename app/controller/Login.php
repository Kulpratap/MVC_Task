<?php
$model = new Model;
$model->test('User');
class Login extends Controller
{
 use User;
  public function check()
  {
    if (isset ($_POST['login'])) {
      // Create an instance of the Database class
      $this->connection(SERVER_NAME, USER_NAME, PASSWORD, DB_NAME);
      // Get form data
      $username = $_POST["username"];
      $password = $_POST["password"];
      $this->checkUserCredentails($username, $password);
      // Close the database connection
      $this->closeConnection();
    }
    if(!(isset($_SESSION['loggedin']) )|| ($_SESSION['loggedin'] == false)){
      $this->view('login');
    }else{
      header("Location:/public/home");
    }
  }
}
