<?php

namespace Blog\Routes;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

use \Blog\View as View;

class ContactPageRoutes {

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
        $app->get('/contact', function (Request $request, Response $response) {

            $response->getBody()->write(
                View::generateContactPage()
            );
            return $response;
        });

        return $app;
    }
}