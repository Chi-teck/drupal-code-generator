<?php

namespace DrupalCodeGenerator\Tests\Other;

use DrupalCodeGenerator\Tests\GeneratorTestCase;
use DrupalCodeGenerator\Commands\Other\DrushCommand;

class DrushCommandTest extends GeneratorTestCase {

  /**
   * {@inheritdoc}
   */
  public function setUp () {
    $this->command = new DrushCommand();
    $this->commandName = 'generate:other:drush-command';
    $this->answers = [
      'Example',
      'example',
      'test',
      'ts',
      'foo',
      'bar',
    ];
    $this->target = 'example.drush.inc';
    $this->fixture = __DIR__ . '/_' . $this->target;
    parent::setUp();
  }

}
