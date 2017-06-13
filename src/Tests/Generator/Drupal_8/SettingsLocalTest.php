<?php

namespace DrupalCodeGenerator\Tests\Generator\Drupal_8;

use DrupalCodeGenerator\Tests\Generator\GeneratorTestCase;

/**
 * Test for d8:settings-local command.
 */
class SettingsLocalTest extends GeneratorTestCase {

  protected $class = 'Drupal_8\SettingsLocal';

  protected $answers = [
    'yes',
    'drupal_8',
    'root',
    '123',
    'localhost',
    'mysql',
  ];

  protected $fixtures = [
    'settings.local.php' => __DIR__ . '/_settings.local.php',
  ];

}
