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
            $sideNav = SideNav::generateSideNavFromBlogs($blogs);

            $response->getBody()->write(
                View::generateBlogView($blogs,$sideNav)
            );
            return $response;
        });

        /**
         * Route for displaying all blogs by a topic name
         */
        $app->get('/blogs/{topic}', function (Request $request, Response $response, $args) {
            // @todo sanitize $args to make sure its safe

            // Getting all blogs by topic
            $blogs = Blogs::getAllRecentBlogsByTopic($args['topic']);
            $sideNav = SideNav::generateSideNavFromBlogs($blogs);

            if (!empty($blogs)) {
                return $response->getBody()->write(View::generateBlogView($blogs,$sideNav));
            } else {
                return $response->getBody()->write(View::generateNotFoundView());
            }
        });

        /**
         * Route for displaying all blogs by month/year
         */
        $app->get('/blogs/date/{year}/{month}', function (Request $request, Response $response, $args) {
            // @todo sanitize $args to make sure its safe

            // Getting all blogs by topic
            $blogs = Blogs::getAllBlogsByYearMonth($args['year'],$args['month']);
            if (!empty($blogs)) {
                return $response->getBody()->write(View::generateBlogView($blogs));
            } else {
                return $response->getBody()->write(View::generateNotFoundView());
            }
        });

        /**
         * Route for displaying a single blog posting
         */
        $app->get('/blog/{topic}/{blogUrl}', function (Request $request, Response $response, $args) {
            // @todo sanitize $args to make sure its safe

            // Getting details about this specific blog
            $blog = Blogs::getSingleBlogDetails($args['topic'], $args['blogUrl']);

            if ($blog) {
                return $response->getBody()->write(
                    View::generateBlogDetailView($blog['data'], $blog['entry'])
                );
            } else {
                return $response->getBody()->write(View::generateNotFoundView());
            }
        });

        /**
         * Route for getting all of the projects; projects listing
         */
        $app->get('/projects[/{tag}]', function (Request $request, Response $response, $args) {
            // @todo sanitize $args to make sure its safe

            $tag = '';
            if (isset($args['tag'])) {
                $tag=$args['tag'];
            }

            // Getting all recent projects
            $projects = Projects::getRecentProjects($tag);
            return $response->getBody()->write(
                View::generateProjectsView($projects)
            );
        });

        /**
         * Route for a single project page
         */
        $app->get('/project/{projectUrl}', function (Request $request, Response $response, $args) {

            $project = Projects::getSingleProject($args['projectUrl']);
            return $response->getBody()->write(
                View::generateSingleProjectView($project)
            );
        });

        /**
         * Route secure admin page
         */
        $app->get('/secure/me', function (Request $request, Response $response, $args) {

            // Check for any existing authentication

        });

        /**
         * For api calls
         */
        $app->map($this->allowed_api_methods, '/api[/{params:.*}]', function (Request $request, Response $response, $args) {
            // @todo sanitize params to make sure its safe

            return $response->withJson([
                'test'=>$request->getAttribute('params')
            ]);
        });

        return $app;
    }
}