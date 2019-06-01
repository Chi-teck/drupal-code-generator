<?php

namespace DrupalCodeGenerator\Tests\Generator\Misc;

use DrupalCodeGenerator\Tests\Generator\BaseGeneratorTest;

/**
 * Test for misc:settings-local command.
 */
class SettingsLocalTest extends BaseGeneratorTest {

  protected $class = 'Misc\SettingsLocal';

  protected  $interaction = [
    'Override database configuration? [No]:' => 'Yes',
    'Database name [drupal_local]:' => 'drupal_8',
    'Database username [root]:' => 'root',
    'Database password:' => '123',
    'Database host [localhost]:' => 'localhost',
    'Database type [mysql]:' => 'mysql',
  ];

  protected $fixtures = [
    'settings.local.php' => '/_settings.local.php',
  ];

}
