<?php

namespace DrupalCodeGenerator\Tests\Drupal_8;

use DrupalCodeGenerator\Tests\GeneratorTestCase;

/**
 * Test for d8:module-file command.
 */
class ModuleFileTest extends GeneratorTestCase {

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    $this->class = 'Drupal_8\ModuleFile';
    $this->answers = [
      'Foo',
      'foo',
    ];
    $this->target = 'foo.module';
    $this->fixture = __DIR__ . '/_' . $this->target;
    parent::setUp();
  }

}
