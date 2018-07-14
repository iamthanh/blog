<?php

namespace Blog\Routes;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

use \Blog\Blogs as Blogs;
use \Blog\View as View;

class IndexRoutes {

    /**
     * This is will set all of the routes related to the index page
     *
     * @param \Slim\App $app
     * @return \Slim\App
     */
    public static function setRoutes(\Slim\App $app) {

        /**
         * Home page or root page
         */
        $app->get('/', function (Request $request, Response $response) {

            // Getting all recent blogs (all topics)
            $blogs = Blogs::getAll();

            $response->getBody()->write(
                View::generateBlogView($blogs)
            );
            return $response;
        });

        return $app;
    }
}