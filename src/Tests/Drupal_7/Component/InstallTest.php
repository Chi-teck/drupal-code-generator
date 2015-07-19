<?php

namespace DrupalCodeGenerator\Tests\Drupal_7\Component;

use DrupalCodeGenerator\Tests\GeneratorTestCase;
use DrupalCodeGenerator\Commands\Drupal_7\Component\Install;

class InstallTest extends GeneratorTestCase {

  /**
   * {@inheritdoc}
   */
  public function setUp () {
    $this->command = new Install();
    $this->commandName = 'generate:d7:component:install-file';
    $this->answers = [
      'Example',
      'example',
    ];
    $this->target = 'example.install';
    $this->fixture = __DIR__ . '/_' . $this->target;
    parent::setUp();
  }

}
