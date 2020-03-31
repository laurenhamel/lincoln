<?php

// Load configurations.
require __DIR__.'/config/config.php';

// Load classes.
require __DIR__.'/classes/autoload.php';

// Load libraries.
require __DIR__.'/libraries/autoload.php';

// Initialize the app.
$app = new Linkn();

// Build the app.
$app->build();

?>
