<?php

/**
 * @file
 * Local development override configuration.
 *
 * @DCG: This file should by included from settings.php file.
 */

// Database settings.
$databases['default']['default'] = array (
  'database' => 'drupal_8',
  'username' => 'root',
  'password' => '123',
  'prefix' => '',
  'host' => 'localhost',
  'port' => '',
  'namespace' => 'Drupal\\Core\\Database\\Driver\\mysql',
  'driver' => 'mysql',
);

// Site name.
$config['system.site']['name'] = '';

// Logging level (hide|some|all|verbose).
$config['system.logging']['error_level'] = 'verbose';

// The maximum time in seconds a page can be cached.
$config['system.performance']['cache.page.max_age'] = 0;

// Aggregate CSS files.
$config['system.performance']['css']['preprocess'] = false;

// Aggregate JS files.
$config['system.performance']['js']['preprocess'] = false;

// Automated cron interval.
$config['automated_cron.settings']['interval'] = 0;
