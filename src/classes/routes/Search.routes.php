<?php

namespace Blog\Routes;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

use \Blog\Blogs as Blogs;
use \Blog\View as View;

class SearchRoutes {

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
        $app->get('/search/{query}', function (Request $request, Response $response, $args) {

            if (empty($args['query'])) {
                return $response->getBody()->write(View::generateNotFoundView());
            }

            // Getting all recent blogs (all topics)
            $blogs = Blogs::searchBlogs($args['query']);

            View::setPageTitle('Results for ' . $args['query']);

            $response->getBody()->write(
                View::generateSearchBlogsView($blogs, $args['query'])
            );
        });

        return $app;
    }
}