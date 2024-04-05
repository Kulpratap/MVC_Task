<?php
// HomeController.php
$model = new Model();
$model->test('User');
$model->test('Post');
class Home extends Controller{
    use User,Post;
    public function check() {
        // Check if the user is logged in
        if ($_SESSION['loggedin'] == true) {
            $this->view('home');
        } else {
            header('Location: login');
        }
    }
}
