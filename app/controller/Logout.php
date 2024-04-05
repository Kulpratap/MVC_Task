<?php
class Logout extends Controller
{
  public function check()
  {
    require '../vendor/autoload.php';

    // Initialize Google Client
    $client = new Google_Client();
    $client->setClientId(YOUR_CLIENT_ID);
    $client->setClientSecret(YOUR_CLIENT_SECRET);
    // Clear access token from Google session
    $client->revokeToken($_SESSION['google_access_token']);

    // Destroy local session data
    session_start();
    $_SESSION = array(); // Clear all session variables
    session_destroy();

    // Redirect to the home page or login page
    header('Location: /public/login'); // Change the URL as needed
    exit;
  }
}