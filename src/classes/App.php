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
        $app = new \Slim\App(['setting'=>Config::getConfig('slim')]);
        $this->loadRoutes($app);

        // Return the \Slim\App
        $app->run();
    }

    public function loadRoutes($app) {
        return new Routes($app);
    }
}