<?php

namespace Blog\Routes;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

use \Blog\Auth as Auth;
use \Blog\Admin as Admin;
use \Blog\View as View;

class AdminRoutes {

    /**
     * This is will set all of the routes related to admin
     *
     * @param \Slim\App $app
     * @return \Slim\App
     */
    public static function setRoutes(\Slim\App $app) {

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

        return $app;
    }
}