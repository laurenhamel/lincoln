<?php

// Locate all libraries.
$libraries = array_values(array_filter(scandir(__DIR__), function($library) {

  // Ignore non-library files.
  return !in_array($library, [
    '.',
    '..',
    '.DS_Store',
    'autoload.php'
  ]);

}));

// Autoload all libraries.
foreach ($libraries as $library) {

  // Include the library.
  include __DIR__."/$library";

}

?>
