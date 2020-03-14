<?php

// Build class.
class Lincoln {

  // Initialize cache.
  protected $cache;

  // Initialize templating engine.
  protected $engine;

  // Initialize data API.
  protected $data;

  // Set the cached data ID.
  public $id = 'airtable';

  // Set the app index template ID.
  public $template = 'index';

  // Construct class.
  function __construct() {

    // Load the cache.
    $this->cache = new Cache();

    // Load the engine.
    $this->engine = new Engine();

    // Load the data API.
    $this->data = new Data();

  }

  // Build the app.
  public function build() {

    // Attempt to get data from the cache.
    if (($data = $this->cache->get($this->id)) === null) {

      // Fetch the data from the API.
      $data = $this->data->fetch();

      // Save the data to the cache.
      $this->cache->set($this->id, $data);

    }

    // Get assets.
    $assets = [
      'css' => Assets::css(),
      'js' => Assets::js()
    ];

    // Merge assets into data.
    $data = [
      'assets' => $assets,
      'links' => $data
    ];

    // Render the index page with the data.
    $this->engine->render($this->template, $data);

  }

}

?>
