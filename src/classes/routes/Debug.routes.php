<?php

namespace Blog\Routes;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

class DebugRoutes {

    /**
     * Testing/debugging routes
     *
     * @param \Slim\App $app
     * @return \Slim\App
     */
    public static function setRoutes(\Slim\App $app) {

        $app->get('/test', function (Request $request, Response $response, $args) {
            return $response->withJson([$_SESSION]);
        });

        return $app;
    }
}