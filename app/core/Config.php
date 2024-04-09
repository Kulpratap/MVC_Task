<?php
namespace app\core;
class Config
{
  public function __construct()
  {
    define('ROOT', 'http://taskmvc.com');
    define('SERVER_NAME', 'localhost');
    define('USER_NAME', 'kul');
    define('PASSWORD', 'Kul@123456');
    define('DB_NAME', 'USER');
    define('YOUR_CLIENT_ID', '472956083216-36bjq70h79u9e6sfm8femjk0k6645aih.apps.googleusercontent.com');
    define('YOUR_CLIENT_SECRET',"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");
    define('YOUR_REDIRECT_URI', 'http://taskmvc.com/public/googlelogin');
  }
}



