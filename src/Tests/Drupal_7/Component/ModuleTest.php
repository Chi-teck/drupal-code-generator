<?php

namespace DrupalCodeGenerator\Tests\Drupal_7\Component;

use DrupalCodeGenerator\Tests\GeneratorTestCase;
use DrupalCodeGenerator\Command\Drupal_7\Component\Module;

class ModuleTest extends GeneratorTestCase {

  /**
   * {@inheritdoc}
   */
  public function setUp () {
    $this->command = new Module();
    $this->commandName = 'generate:d7:component:module-file';
    $this->answers = [
      'Example',
      'example',
    ];
    $this->target = 'example.module';
    $this->fixture = __DIR__ . '/_' . $this->target;
    parent::setUp();
  }

}
