<?php

namespace DrupalCodeGenerator\Tests\Drupal_8;

use DrupalCodeGenerator\Tests\GeneratorTestCase;

/**
 * Test for d8:settings-local command.
 */
class SettingsLocalTest extends GeneratorTestCase {

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    $this->class = 'Drupal_8\SettingsLocal';
    $this->answers = [
      'drupal_8',
      'root',
      '123',
      'localhost',
      'mysql',
    ];
    $this->target = 'settings.local.php';
    $this->fixture = __DIR__ . '/_settings_local.php';

    parent::setUp();
  }

}
