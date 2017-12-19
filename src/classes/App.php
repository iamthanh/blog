<?php

namespace Blog;

/**
 * This is the main class for the blog application
 *
 * Class App
 * @package Blog
 */
class App {

    // Object of \Slim\App
    public $app;

    public static $container;

    /**
     * @var \Doctrine\ORM\EntityManager $container
     */
    public static $entityManager;

    public function __construct($entityManager) {
        $app = new \Slim\App(['setting'=>Config::getConfig('slim')]);
        $this->loadRoutes($app);

        session_start();

        static::$container = $app->getContainer();
        static::$entityManager = $entityManager;

        // Return the \Slim\App
        $app->run();
    }

    public function loadRoutes($app) {
        return new Routes($app);
    }
}