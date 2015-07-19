<?php

namespace DrupalCodeGenerator\Tests\Drupal_7\Component;

use DrupalCodeGenerator\Tests\GeneratorTestCase;
use DrupalCodeGenerator\Commands\Drupal_7\Component\Settings;

class SettingsTest extends GeneratorTestCase {

  /**
   * {@inheritdoc}
   */
  public function setUp () {
    $this->command = new Settings();
    $this->commandName = 'generate:d7:component:settings.php';
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
