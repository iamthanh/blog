<?php
// Load the autoload for vendor
require_once __DIR__.'/../../vendor/autoload.php';

// Load doctrine
require_once __DIR__.'/../doctrine-bootstrap.php';

// Run the app
new \Blog\App;