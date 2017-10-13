<?php

namespace Blog;

class Routes {

    /**
     * Takes the \Slim\App object as a parameter
     * and loads routes to it
     *
     * Routes constructor.
     * @param \Slim\App $app
     */
    public function __construct(\Slim\App $app) {
        error_log(print_r($app,true));

    }
}