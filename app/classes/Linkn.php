<?php

// Build class.
class Linkn {

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

    // Get static data.
    $static = scandir_clean(CONFIG['ASSETS'].'/data');

    // Read static data.
    foreach($static as $i => $file) {

      // Get full file path.
      $path = CONFIG['ASSETS'].'/data/'.$file;

      // Get the base filename.
      $basename = basename($file, '.json');

      // Read the static data and save it.
      $static[$basename] = json_decode(file_get_contents($path), true);

      // Remove the filename from the static array.
      unset($static[$file]);

    }

    // Get assets.
    $assets = [
      'css' => Assets::css(),
      'js' => Assets::js()
    ];

    // Merge all data.
    $data = array_merge([
      'assets' => $assets,
      'links' => $data,
      'path' => [
        'app' => CONFIG['URIROOT'].str_replace(CONFIG['ROOT'], '', CONFIG['APP']),
        'assets' => CONFIG['URIROOT'].str_replace(CONFIG['ROOT'], '', CONFIG['ASSETS']),
        'root' => CONFIG['URIROOT']
      ]
    ], $static);

    // Render the index page with the data.
    $this->engine->render($this->template, $data);

  }

}

?>
