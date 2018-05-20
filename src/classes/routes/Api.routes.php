<?php

namespace Blog\Routes;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

use \Blog\Admin as Admin;
use \Blog\Auth as Auth;

class ApiRoutes {

    /**
     * This will set the routes for Apis
     *
     * @param \Slim\App $app
     * @return \Slim\App
     */
    public static function setRoutes(\Slim\App $app) {

        /**
         * Api route for logging in for /secure/me
         */
        $app->post('/api/login', function (Request $request, Response $response, $args) {

            $data = $request->getParsedBody();
            // Checking that username and password was passed in
            if (!empty($data['username']) && !empty($data['password'])) {

                /** @var \Entities\Users $user */
                $user = Auth::verifyLogin($data['username'], $data['password']);

                // Verify login
                if ($user) {
                    return $response->withJson(['status'=>Auth::storeUserDataInSession($user)]);
                }
            }

            return $response->withJson(['status'=>false]);

        })->add(\Blog\Routes\Middlewares\CsrfMiddleware::class);

        /**
         * This Api call will logout any user logged in
         */
        $app->get('/api/logout', function(Request $request, Response $response, $args) {
            Auth::logout();

            return $response->withJson([$_SESSION]);
        });

        /**
         * post request for creating / updating a blog post from edit modal
         */
        $app->post('/api/admin/blog', function(Request $request, Response $response, $args) {

            // Check that the data exist, and verify/sanitize it
            $postData = $request->getParsedBody();
            if (!empty($postData) && !empty($postData['actionType'])) {

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

            return $response->withJson(['status'=>false,'message'=>'Missing require post data']);

        })->add(\Blog\Routes\Middlewares\CsrfMiddleware::class);

        /** Endpoint for deleting blogs */
        $app->delete('/api/admin/blog', function(Request $request, Response $response, $args) {

            $postData = $request->getParsedBody();

            if (!empty($postData) && !empty($postData['id'])) {
                $results = Admin::deleteBlogPost($postData['id']);

                return $response->withJson(['status'=>$results['status'], 'message'=>$results['message']]);
            }

            return $response->withJson(['status'=>false, 'message'=> 'There was an error, could not delete blog']);

        })->add(\Blog\Routes\Middlewares\CsrfMiddleware::class);

        $app->get('/api/admin/{dataType}', function(Request $request, Response $response, $args) {

            if (Auth::isLoggedIn()) {
                return $response->withJson([
                    'status' => true,
                    'data' => Admin::getBlogsForAdmin()
                ]);
            }

            return $response->withJson(['status'=>false]);

        })->add(\Blog\Routes\Middlewares\CsrfMiddleware::class);

        return $app;
    }
}