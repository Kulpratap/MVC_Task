<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once '../vendor/autoload.php';
use app\core\App;
$router = new App();
$router->loadPage();
