<?php

namespace Blog\Routes;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

use \Blog\Blogs as Blogs;
use \Blog\View as View;
use \Blog\SideNav as SideNav;

class BlogsRoutes {

    /**
     * This is will set all of the routes related to blogs
     *
     * @param \Slim\App $app
     * @return \Slim\App
     */
    public static function setRoutes(\Slim\App $app) {

        /**
         * Route for displaying all blogs by a topic name
         */
        $app->get('/blogs/{topic}', function (Request $request, Response $response, $args) {
            // @todo sanitize $args to make sure its safe

            // Getting all blogs by topic
            $blogsFound = Blogs::getBlogs($args['topic']);
            $sideNav = SideNav::generateSideNavFromBlogs($blogsFound);
            return $response->getBody()->write(View::generateBlogView($blogsFound, $sideNav, $args['topic']));
        });

        /**
         * Route for displaying all blogs by month/year
         */
        $app->get('/blogs/date/{year}/{month}', function (Request $request, Response $response, $args) {
            // @todo sanitize $args to make sure its safe

            // Getting all blogs by topic
            $blogs = Blogs::getAllBlogsByYearMonth($args['year'],$args['month']);
            $sideNav = SideNav::generateSideNavFromBlogs($blogs);
            return $response->getBody()->write(View::generateBlogView($blogs, $sideNav));
        });

        /**
         * Route for displaying a single blog posting
         */
        $app->get('/blog/{blogUrl}', function (Request $request, Response $response, $args) {
            // @todo sanitize $args to make sure its safe

            // Getting details about this specific blog
            $blog = Blogs::getSingleBlogDetails($args['blogUrl']);
            return $response->getBody()->write(
                View::generateBlogDetailView($blog)
            );
        });

        return $app;
    }
}