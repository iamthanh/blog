<?php

// Load the autoload for vendor
require_once __DIR__.'/../vendor/autoload.php';

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

$entitiesPath = array(__DIR__ . '/entities');
$proxiesPath = __DIR__ . '/proxies';
$proxiesNamespace = 'Proxies';

$serverConfig = \Blog\Config::getConfig('server');
$isDevMode = $serverConfig['isProduction'] ? false : true;

// Connection configuration
$dbConfig = \Blog\Config::getConfig('db');
$mysqlConfig = $dbConfig['mysql'];
$dbParams = array(
    'dbname'       => $mysqlConfig['dbname'],
    'host'         => $mysqlConfig['host'],
    'user'         => $mysqlConfig['user'],
    'port'         => $mysqlConfig['port'],
    'password'     => $mysqlConfig['password'],
    'driver'       => $mysqlConfig['doctrine_driver_name'],
    'charset'      => $mysqlConfig['charset']
);

if ($isDevMode) {
    $cache = new \Doctrine\Common\Cache\ArrayCache();
} else {
    $cache = new \Doctrine\Common\Cache\ApcCache();
}

// Setting up config for ORM
$ORM_config = new \Doctrine\ORM\Configuration();
$ORM_config->setMetadataCacheImpl($cache);
$driverImpl = $ORM_config->newDefaultAnnotationDriver($entitiesPath);
$ORM_config->setMetadataDriverImpl($driverImpl);
$ORM_config->setProxyDir($proxiesPath);
$ORM_config->setProxyNamespace($proxiesNamespace);

/** Defining additional mysql functions from DoctrineExtensions */
$ORM_config->addCustomStringFunction('GROUP_CONCAT', 'DoctrineExtensions\Query\Mysql\GroupConcat');
$ORM_config->addCustomStringFunction('YEAR', 'DoctrineExtensions\Query\Mysql\Year');
$ORM_config->addCustomStringFunction('MONTH', 'DoctrineExtensions\Query\Mysql\Month');

//$config = Setup::createAnnotationMetadataConfiguration($paths, $isDevMode);
$entityManager = EntityManager::create($dbParams, $ORM_config);

$platform = $entityManager->getConnection()->getDatabasePlatform();
$platform->registerDoctrineTypeMapping('enum', 'string');
