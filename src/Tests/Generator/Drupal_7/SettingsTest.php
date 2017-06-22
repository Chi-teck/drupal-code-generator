<?php

namespace DrupalCodeGenerator\Tests\Generator\Drupal_7;

use DrupalCodeGenerator\Tests\Generator\GeneratorBaseTest;

/**
 * Test for d7:settings.php command.
 */
class SettingsTest extends GeneratorBaseTest {

  protected $class = 'Drupal_7\Settings';

  protected $interaction = [
    'Database driver [mysql]: ' => 'mysql',
    'Database name [drupal]: ' => 'drupal',
    'Database user [root]: ' => 'root',
    'Database password [123]: ' => '123',
  ];

  protected $fixtures = [
    'settings.php' => __DIR__ . '/_settings.php',
  ];

}
