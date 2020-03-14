<?php

// Load configurations.
require __DIR__.'/config/config.php';

// Load classes.
require __DIR__.'/classes/autoload.php';

// Initialize the app.
$app = new Lincoln();

// Build the app.
$app->build();

?>
