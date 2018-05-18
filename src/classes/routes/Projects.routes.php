<?php

namespace Blog\Routes;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

use \Blog\Projects as Projects;
use \Blog\View as View;

class ProjectsRoutes {

    /**
     * This is will set all of the routes related to projects
     *
     * @param \Slim\App $app
     * @return \Slim\App
     */
    public static function setRoutes(\Slim\App $app) {

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

        return $app;
    }
}