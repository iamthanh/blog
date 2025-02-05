<?php

namespace Blog\Routes;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

use \Blog\Blogs as Blogs;
use \Blog\View as View;
use \Blog\SideNav as SideNav;

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
            $allBlogs = Blogs::getAll();
            $sideNav = SideNav::generateSideNavFromBlogs($allBlogs);

            View::setPageTitle('All recent blogs');

            $response->getBody()->write(
                View::generateBlogView($allBlogs, $sideNav)
            );
            return $response;
        });

        return $app;
    }
}