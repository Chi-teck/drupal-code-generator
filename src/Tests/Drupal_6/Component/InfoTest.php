<?php

namespace DrupalCodeGenerator\Tests\Drupal_6\Component;

use DrupalCodeGenerator\Tests\GeneratorTestCase;
use DrupalCodeGenerator\Commands\Drupal_6\Component\Info;

class InfoTest extends GeneratorTestCase {

  /**
   * {@inheritdoc}
   */
  public function setUp () {
    $this->command = new Info();
    $this->commandName = 'generate:d6:component:info-file';
    $this->answers = [
      'Example',
      'example',
      'Some description',
      'custom',
      '6.x-1.0',
    ];
    $this->target = 'example.info';
    $this->fixture = __DIR__ . '/_' . $this->target;

    parent::setUp();
  }

}
