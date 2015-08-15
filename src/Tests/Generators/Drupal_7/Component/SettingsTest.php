<?php

namespace DrupalCodeGenerator\Tests\Drupal_7\Component;

use DrupalCodeGenerator\Tests\GeneratorTestCase;

/**
 * Test for d7:component:settings.php command.
 */
class SettingsTest extends GeneratorTestCase {

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    $this->class = 'Drupal_7\Component\Settings';
    $this->answers = [
      'mysql',
      'drupal',
      'root',
      '123',
    ];
    $this->target = 'settings.php';
    $this->fixture = __DIR__ . '/_' . $this->target;

    parent::setUp();
  }

}
