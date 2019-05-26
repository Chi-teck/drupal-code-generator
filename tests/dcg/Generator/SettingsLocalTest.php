<?php

namespace DrupalCodeGenerator\Tests\Generator;

/**
 * Test for settings-local command.
 */
class SettingsLocalTest extends BaseGeneratorTest {

  protected $class = 'SettingsLocal';

  protected  $interaction = [
    'Override database configuration? [No]:' => 'Yes',
    'Database name [drupal_local]:' => 'drupal_8',
    'Database username [root]:' => 'root',
    'Database password:' => '123',
    'Database host [localhost]:' => 'localhost',
    'Database type [mysql]:' => 'mysql',
  ];

  protected $fixtures = [
    'settings.local.php' => __DIR__ . '/_settings.local.php',
  ];

}
