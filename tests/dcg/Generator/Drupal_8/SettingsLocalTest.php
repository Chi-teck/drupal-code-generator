<?php

namespace DrupalCodeGenerator\Tests\Generator\Drupal_8;

use DrupalCodeGenerator\Tests\Generator\GeneratorBaseTest;

/**
 * Test for d8:settings-local command.
 */
class SettingsLocalTest extends GeneratorBaseTest {

  protected $class = 'Drupal_8\SettingsLocal';

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
