<?php
namespace app\core;
class Routing
{
    /** @var string $url The URL to be processed. */
    private $url;
    private $controller = 'login';
    private $method = 'check';
    /**
     * Constructor for Router class.
     */
    public function __construct()
    {
        $x = isset($_GET['url']) ? $_GET['url'] : NULL;
        if ($x == NULL) {
            $y = 'login';
        } else {
            $y = str_replace('/public/', '', $x);
        }
        $this->url = $y;
    }

    /**
     * Splits the URL into an array of segments.
     *
     * @return array The array of URL segments.
     */
    public function splitURL()
    {
        // Explode the URL into segments using the forward slash (/) as the delimiter.
        $content = explode('/', $this->url);
        return $content;
    }

    /**
     * Loads the appropriate controller based on the URL.
     *
     * @return void
     */
    public function loadPage()
    {
      
        // Split the URL into segments.
        $URL = $this->splitURL();

        // Determine the controller based on the first segment of the URL.
        $controller = ucfirst($URL[0]);

        // Construct the filename for the controller.
        $filename = "../app/controller/$controller.php";

        // If the controller file exists, require it.
        if (file_exists($filename)) {
            require ($filename);
            $this->controller = '\app\\controller\\'.$controller;
        } else {
            // If the controller file does not exist, require the 404 controller.
            require ("../app/controller/_404.php");
            $this->controller = "\app\\controller\\"."_404";
        }
        $con = new $this->controller();
        call_user_func_array([$con, $this->method], []);
    }
}

// Instantiate the Router class and load the appropriate controller.

