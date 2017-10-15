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

        // Home page or root page
        $app->get('/', function (Request $request, Response $response) {
            $response->getBody()->write(
                View::generateBlogView(['test'=>'this is great!'])
            );
            return $response;
        });

        $app->get('[/{params:.*}]', function ($request, $response, $args) {
            $params = explode('/', $request->getAttribute('params'));
            $response->getBody()->write(
                View::generateBlogView($params)
            );
            return $response;
        });

        return $app;
    }
}