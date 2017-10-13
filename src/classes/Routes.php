<?php

namespace Blog;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

class Routes {

    /**
     * Takes the \Slim\App object as a parameter
     * and loads routes to it
     *
     * Routes constructor.
     * @param \Slim\App $app
     */
    public function __construct(\Slim\App $app) {
        $app->get('/', function (Request $request, Response $response) {
            $response->getBody()->write(
                Template::load(
                    'header.php', [
                    'test'=>'this is great!'
                ])
            );
            return $response;
        });

        return $app;
    }
}