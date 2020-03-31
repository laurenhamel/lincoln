<?php

// Define configurations.
define('CONFIG', [

  'ENV' => ($ENV = $_ENV['APP_ENV'] ?? 'development'),

  'DEV' => $ENV === 'development',

  'APP' => ($APP = dirname(__DIR__)),

  'ROOT' => ($ROOT = dirname($APP)),

  'URIROOT' => '/'.str_replace($_SERVER['DOCUMENT_ROOT'], '', $ROOT),

  'ASSETS' => $ROOT.'/public',

  'AIRTABLE' => [
    'KEY' => $_ENV['AIRTABLE_API_KEY'],
    'BASE' => $_ENV['AIRTABLE_BASE_ID'],
    'TABLE' => $_ENV['AIRTABLE_TABLE_NAME']
  ],

  'CACHE' => [
    'PATH' => $APP.'/cache',
    'EXPIRES' => $_ENV['CACHE_INTERVAL']
  ]

]);

?>
