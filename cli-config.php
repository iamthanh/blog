<?php
require_once __DIR__.'/src/doctrine-bootstrap.php';
return \Doctrine\ORM\Tools\Console\ConsoleRunner::createHelperSet($entityManager);