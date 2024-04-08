<?php
// $model = new Model;
// $model->test('User');
// $model->test('Post');
namespace app\controller;
use app\core\Controller;
use app\models\Post;
use app\models\User;
class Home extends Controller
{
    use User, Post;
    public function check()
    {
        // Check if the user is logged in
        if ($_SESSION['loggedin'] == true) {
            $this->view('home');
        } else {
            header('Location: login');
        }
    }
}
