<?php

// Load dependencies.
use \Twig\Loader\FilesystemLoader as Loader;
use \Twig\Environment as Twig;

// Load extensions.
use \Twig\Extension\DebugExtension;

// Build class.
class Engine {

  // Initialize template loader.
  protected $loader;

  // Initialize template engine.
  protected $engine;

  // Construct class.
  function __construct() {

    // Initialize the loader.
    $this->loader = new Loader(CONFIG['ASSETS'].'/partials');

    // Initialize the engine.
    $this->engine = new Twig($this->loader, [
      'debug' => CONFIG['DEV']
    ]);

    // Register Twig extensions.
    if (CONFIG['DEV']) $this->engine->addExtension(new DebugExtension());

  }

  // Render template.
  public function render(string $template, array $data) {

    // Clean the template string.
    $template = preg_replace('/\.twig$/', '', $template);

    // Render the template with the data.
    echo $this->engine->render("$template.twig", $data);

  }

}

?>
