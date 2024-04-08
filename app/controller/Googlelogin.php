<?php
// $model = new Model;
// $model->test('User');
namespace app\controller;
use app\core\Controller;
use app\models\User;
use app\core\Config;
class Googlelogin extends Controller
{
  use User;
 
  public function check()
  {
    new Config;
    $this->connection(SERVER_NAME, USER_NAME, PASSWORD, DB_NAME);
    $this->googleAuth();
  }
}
