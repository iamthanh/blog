<?php

// Load the autoload for vendor
require_once __DIR__.'/../vendor/autoload.php';

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

$paths = array(__DIR__ . '/entities');
$isDevMode = false;

// Connection configuration
$dbConfig = \Blog\Config::getConfig('db');
$mysqlConfig = $dbConfig['mysql'];
$dbParams = array(
    'dbname' => $mysqlConfig['dbname'],
    'host'=>$mysqlConfig['host'],
    'user'=>$mysqlConfig['user'],
    'password'=>$mysqlConfig['password'],
    'driver'=>$mysqlConfig['doctrine_driver_name']
);

$config = Setup::createAnnotationMetadataConfiguration($paths, $isDevMode);
$entityManager = EntityManager::create($dbParams, $config);

$platform = $entityManager->getConnection()->getDatabasePlatform();
$platform->registerDoctrineTypeMapping('enum', 'string');