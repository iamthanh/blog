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
         * Route for displaying all blogs by a topic name
         */
        $app->get('/blog/{topic}', function (Request $request, Response $response, $args) {
            // @todo sanitize $args['topic'] to make sure its safe

            // Getting all blogs by topic
            $blogs = Blogs::getAllRecentBlogsByTopic($args['topic']);

            $response->getBody()->write(
                View::generateBlogView(['blogs'=>$blogs])
            );
            return $response;
        });

        /**
         * Route for displaying a single blog posting
         */
        $app->get('/blog/{topic}/{blogUrl}', function (Request $request, Response $response, $args) {

            // Getting all blogs by topic
            $blog = Blogs::getSingleBlogDetails($args['topic'], $args['blogUrl']);
            $response->getBody()->write(
                View::generateBlogDetailView($blog['data'], $blog['entry'])
            );
            return $response;
        });

        /**
         * Route for getting all of the projects; projects listing
         */
        $app->get('/projects', function (Request $request, Response $response, $args) {

            $projects = Projects::getAllRecentProjects();
            $response->getBody()->write(
                View::generateProjectsView(['projects'=>$projects])
            );
            return $response;
        });

        $app->get('/project/[{params:.*}]', function (Request $request, Response $response, $args) {

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