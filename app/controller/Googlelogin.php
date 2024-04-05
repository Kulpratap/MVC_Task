<?php
$model=new Model();
$model->test('User');
class Googlelogin extends Controller
{
  use User;
  public function check()
  {
    $this->connection(SERVER_NAME, USER_NAME, PASSWORD, DB_NAME);
    $this->googleAuth();
  }    
}
