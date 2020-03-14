<?php

// Build class.
class Cache {

  // Set cache path.
  protected $path = CONFIG['CACHE']['PATH'];

  // Set cache expiry time.
  protected $expiration = CONFIG['CACHE']['EXPIRES'];

  // Get the file path of some data within the cache.
  protected function file(string $key) {

    // Return the cache file path.
    return $this->path."/$key.php";

  }

  // Write some data to the cache.
  protected function write(string $key, $data) {

    // Convert the data to storable PHP content.
    $php = '<?php return '.var_export($data, true).'; ?>';

    // Save the data to the cache.
    return file_put_contents($this->file($key), $php);

  }

  // Delete some data from the cache.
  protected function delete(string $key) {

    // Delete a file in the cache.
    return ($this->exists($key) ? unlink($this->file($key)) : true);

  }

  // Read some data from the cache.
  protected function read(string $key) {

    // Load the data from the cache.
    return include($this->file($key));

  }

  // Determine if some data exists within the cache.
  protected function exists(string $key) {

    return file_exists($this->file($key));

  }

  // Determine if some data within the cache has expired.
  protected function expired(string $key) {

    // Determine if the file has expired.
    return (time() - filemtime($this->file($key)) >= $this->expiration);

  }

  // Get some data out of the cache.
  public function get(string $key, $default = null) {

    // Determine if the data exists.
    if ($this->exists($key)) {

      // Check to see if the data has expired.
      if ($this->expired($key)) {

        // If so, delete the data.
        $this->delete($key);

        // Return the default.
        return $default;

      }

      // Otherwise, fetch the data, and return it.
      else $this->read($key);

    }

    // Otherwise, return the default.
    return $default;

  }

  // Set some data in the cache.
  public function set(string $key, $data, $overwrite = false) {

    // Only continue if the data doesn't exist or overwrite was enabled.
    if (!$this->exists($key) or ($this->exists($key) and $overwrite)) {

      // Save the data to the cache.
      $result = $this->write($key, $data);

      // Return the result.
      return $result !== false;

    }

    // Otherwise, indicate that the data could not be set.
    return false;

  }


}

?>
