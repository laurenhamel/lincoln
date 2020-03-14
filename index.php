<?php

// Autoload dependencies.
require __DIR__.'/vendor/autoload.php';

// Load environment.
(\Dotenv\Dotenv::createImmutable(__DIR__))->load();

// Initialize the app.
require __DIR__.'/app/entry.php';

?>
