<?php

// Register autoloader.
spl_autoload_register(function ($class) {

  // Get the file path.
  $path = __DIR__."/$class.php";

  // See if the file exists, and load it if so.
  if (file_exists($path)) {

    // Load the class.
    require_once $path;

    // Done.
    return true;

  }

  // Otherwise, class doesn't exist.
  return false;


});

?>
