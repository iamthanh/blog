<?php

namespace Blog;

/**
 * This is the main class for the blog application
 *
 * Class App
 * @package Blog
 */
class App {

    // Object of \Slim\App
    public $app;

    public function __construct() {

        $this->app = new \Slim\App;
        $this->loadRoutes();
    }

    public function loadRoutes() {

        $this->app = new Routes($this->app);
    }
}