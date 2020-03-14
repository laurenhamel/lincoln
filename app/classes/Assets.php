<?php

// Build class.
class Assets {

  // Scan a directory for its contents.
  protected static function scan(string $directory, bool $recursive = true) {

    // Create a blacklist of files to ignore.
    $ignore = ['.', '..', '.DS_Store'];

    // Initialize a helper for scrubbing blacklisted files from a directory listing.
    $scrub = function($files) use ($ignore) {

      // Remove blacklisted files, and return the directory contents.
      return array_values(array_filter($files, function($file) use ($ignore) {

        // Remove ignored files.
        return !in_array($file, $ignore);

      }));

    };

    // Initialize a helper method for resolving full file paths.
    $resolve = function($files) use ($directory) {

      // Resolve file names to use full file paths.
      return array_map(function($file) use ($directory) {

        // Prepend the directory name to the file name.
        return $directory.'/'.$file;

      }, $files);

    };

    // Make sure the directory exists.
    if (is_dir($directory)) {

      // Scan the directory for its contents.
      $contents = $resolve($scrub(scandir($directory)));

      // If recursion is enabled, then continue to scan subdirectories.
      foreach($contents as $file) {

        // Check for subdirectories.
        if (is_dir($file)) {

          // Capture the files within the subdirectory.
          $contents = array_merge($contents, static::scan($file, $recursive));

        }

      }

      // Return the directory's contents.
      return $contents;

    }

    // Otherwise, indicate that a directory was not given.
    return false;

  }

  // Get asset paths as relative paths from index.
  protected static function relative($files) {

    // Convert file paths to relative.
    return array_map(function($file) {

      // Remove root path and leading slash.
      return ltrim('/', str_replace(CONFIG['ROOT'], '', $file));

    }, $files);

  }

  // Get asset paths as absolute paths.
  protected static function absolute($files) {

    // Convert file paths to absolute.
    return array_map(function($file) {

      // Prepend with protocol and domain and remove document root.
      return '//'.$_SERVER['HTTP_HOST'].'/'.str_replace($_SERVER['DOCUMENT_ROOT'], '', $file);

    }, $files);

  }

  // Get a list of the app's JS scripts.
  public static function js(bool $relative = false) {

    // Read the contents of the JS directory.
    $contents = static::scan(CONFIG['ASSETS'].'/js');

    // Return as either absolute or relative paths.
    return ($relative ? static::relative($contents) : static::absolute($contents));

  }

  // Get a list of app's CSS stylesheets.
  public static function css(bool $relative = false) {

    // Read the contents of the CSS directory.
    $contents = static::scan(CONFIG['ASSETS'].'/css');

    // Return as either absolute or relative paths.
    return ($relative ? static::relative($contents) : static::absolute($contents));

  }

}

?>
