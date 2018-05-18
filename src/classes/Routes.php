<?php

namespace Blog;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

class Routes {

    const ROUTE_FILE_SUFFIX = '.routes.php';
    const ROUTE_CLASS_SUFFIX = 'Routes';
    const ROUTE_SET_FUNCTION_NAME = 'setRoutes';
    const ROUTE_NAMESPACE = 'Blog\Routes\\';

    public static $routesFolder = '/routes';

    /**
     * Takes the \Slim\App object as a parameter
     * and loads routes to it
     *
     * Routes constructor.
     * @param \Slim\App $app
     */
    public function __construct(\Slim\App $app) {

        // Getting the routes folder
        $routesFolderPath = __DIR__ . self::$routesFolder;
        $routesFound = array_diff(scandir($routesFolderPath), array('..', '.'));

        foreach($routesFound as $route) {
            $routeClass = str_replace(self::ROUTE_FILE_SUFFIX, '', $route) . self::ROUTE_CLASS_SUFFIX;
            $routeClass = self::ROUTE_NAMESPACE . $routeClass;

            if (method_exists($routeClass,self::ROUTE_SET_FUNCTION_NAME)) {
                $app = $routeClass::{self::ROUTE_SET_FUNCTION_NAME}($app);
            }
        }

        return $app;
    }
}