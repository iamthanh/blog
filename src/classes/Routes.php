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

            // Getting all recent blogs (all topics)
            $blogs = Blogs::getAllRecentBlogs();

            $response->getBody()->write(
                View::generateBlogView(['blogs' => $blogs])
            );
            return $response;
        });

        /**
         * For blog topic/single pages
         */
        $app->get('/blog/[{params:.*}]', function (Request $request, Response $response, $args) {

            $params = explode('/', $request->getAttribute('params'));
            $topic = isset($params[0]) ? $params[0] : '';
            $blogName = isset($params[1]) ? $params[1] : '';

            // Getting all blogs by topic
            $blogs = Blogs::getAllRecentBlogsByTopic($topic);

            $response->getBody()->write(
                View::generateBlogView(['blogs'=>$blogs])
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