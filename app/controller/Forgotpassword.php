<?php
namespace app\controller;
use app\core\Controller;
use app\models\User;
class Forgotpassword  extends Controller{
  use User;
   public function check(){
    if (isset($_POST["submit"])) {
      $this->retriveMail($_POST['mail']);
      $this->forgotPassword();
    }
    if($_SESSION['loggedin']==false){
      $this->view('forgotpassword');
      }else{
        header("Location:home");
      }
   }
 }