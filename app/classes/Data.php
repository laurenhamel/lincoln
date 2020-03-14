<?php

// Load dependencies.
use \TANIOS\Airtable\Airtable;

// Build class.
class Data {

  // Initialize data API.
  protected $api;

  // Construct class.
  function __construct() {

    // Initialize the API.
    $this->api = new Airtable([
      'api_key' => CONFIG['AIRTABLE']['KEY'],
      'base' => CONFIG['AIRTABLE']['BASE']
    ]);

  }

  // Fetch table data.
  public function fetch(string $table = CONFIG['AIRTABLE']['TABLE']) {

    // Initialize the data set.
    $data = [];

    // Build the API request.
    $request = $this->api->getContent($table);

    // Process the request.
    do {

      // Get the response.
      $response = $request->getResponse();

      // Save the response data.
      $data = array_merge($data, $response['records']);

    } while ($request = $response->next());

    // Return the data.
    return $data;

  }

}

?>
