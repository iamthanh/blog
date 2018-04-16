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
            $projects = Projects::getProjects($tag);
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

        $app->get('/test', function (Request $request, Response $response, $args) {
            return $response->withJson([$_SESSION]);
        });

        /**
         * Api route for logging in for /secure/me
         */
        $app->post('/api/login', function (Request $request, Response $response, $args) {
            $data = $request->getParsedBody();

            // Checking that username and password was passed in
            if (!empty($data['username']) && !empty($data['password'])) {

                if (empty($data['token'])) {
                    trigger_error('Missing csrf token in request when required.');
                    return $response->withJson(['status'=>false]);
                }

                // If the csrf token is missing in the session, then reloading the page is required
                if (empty($_SESSION[Auth::SESSION_CSRF_TOKEN_KEY])) {
                    return $response->withJson(['status'=>false,'reload'=>false]);
                }

                // Verify csrf token
                if (Auth::verifyCsrfToken($data['token'])) {
                    /** @var \Entities\Users $user */
                    $user = Auth::verifyLogin($data['username'], $data['password']);

                    // Verify login
                    if ($user) {
                        return $response->withJson(['status'=>Auth::storeUserDataInSession($user)]);
                    }
                } else {
                    trigger_error('secure/me login failed: mismatch csrf token');
                }
            }

            return $response->withJson(['status'=>false]);
        });

        /**
         * This Api call will logout any user logged in
         */
        $app->get('/api/logout', function(Request $request, Response $response, $args) {
            Auth::logout();

            return $response->withJson([$_SESSION]);
        });

        /**
         * Route secure admin page
         */
        $app->get('/secure/admin', function (Request $request, Response $response, $args) {

            /** Check if any existing logged in sessions */
            if (Auth::isLoggedIn()) {

                // Get all of the data needed for the admin page using the params
                $adminData = Admin::getBlogsForAdmin();

                // Load the content management system
                return $response->getBody()->write(View::generateSecureCMS($adminData));
            }

            return $response->getBody()->write(View::generateSecureLoginPageView());
        });

        /**
         * post request for creating / updating a blog post from edit modal
         */
        $app->post('/api/admin/blog', function(Request $request, Response $response, $args) {

            // Check that the data exist, and verify/sanitize it
            $postData = $request->getParsedBody();
            if (!empty($postData) && !empty($postData['actionType'])) {

                // @todo check for the csrf token

                $cleanData = Admin::sanitizeAndVerifyEditModalData($postData['data']);
                if($cleanData) {
                    // Checking if we are creating or editing a blog post
                    if ($postData['actionType'] === 'create') {
                        $results = Admin::createNewBlogPost($cleanData);
                    } else if ($postData['actionType'] === 'edit') {
                        $results = Admin::updateBlogDataByBlogId($cleanData);
                    }

                    return $response->withJson(['status'=>$results['status'], 'message'=>$results['message'] ]);
                } else {
                    // Verification failed
                    return $response->withJson(['status'=>false,'message'=>'Error: failed to verify the post data.']);
                }
            }
        });

        $app->get('/api/admin/{dataType}', function(Request $request, Response $response, $args) {
            $data = $request->getQueryParams();
            if (!empty($data) && !empty($data[Auth::SESSION_CSRF_TOKEN_KEY])) {
                if (Auth::verifyCsrfToken($data[Auth::SESSION_CSRF_TOKEN_KEY])) {
                    if (Auth::isLoggedIn()) {
                        return $response->withJson([
                            'status' => true,
                            'data' => Admin::getBlogsForAdmin()
                        ]);
                    }
                } else {
                    trigger_error('admin failed: mismatch csrf token');
                }
            } else {
                trigger_error('Missing csrf token in request when required.');
            }

            return $response->withJson(['status'=>false]);
        });

        return $app;
    }
}