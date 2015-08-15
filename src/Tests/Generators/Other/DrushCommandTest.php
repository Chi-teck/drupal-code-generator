<?php

namespace DrupalCodeGenerator\Tests\Other;

use DrupalCodeGenerator\Tests\GeneratorTestCase;

/**
 * Test for other:drush-command command.
 */
class DrushCommandTest extends GeneratorTestCase {

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    $this->class = 'Other\DrushCommand';
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
