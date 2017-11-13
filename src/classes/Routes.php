<?php

namespace Blog;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

class Routes {

    private $allowed_api_methods = ['post','get'];

    /**
     * Takes the \Slim\App object as a parameter
     * and loads routes to it
     *
     * Routes constructor.
     * @param \Slim\App $app
     */
    public function __construct(\Slim\App $app) {
        /**
         * Home page or root page
         */
        $app->get('/', function (Request $request, Response $response) {

            $blogs = App::$entityManager->getRepository('Entities\Blogs')->findAll();

            $response->getBody()->write(
                View::generateBlogView(['blogs'=>$blogs])
            );
            return $response;
        });

        /**
         * For blog pages
         */
        $app->get('/blog/[{params:.*}]', function (Request $request, Response $response, $args) {
            $params = explode('/', $request->getAttribute('params'));

            $response->getBody()->write(
                View::generateBlogView($params)
            );
            return $response;
        });

        /**
         * For api calls
         */
        $app->map($this->allowed_api_methods, '/api[/{params:.*}]', function (Request $request, Response $response, $args) {
            return $response->withJson([
                'test'=>$request->getAttribute('params')
            ]);
        });

        return $app;
    }
}