<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once '../vendor/autoload.php';
use app\core\Routing;
$router = new Routing();
$router->loadPage();
