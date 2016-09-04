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
      'yo-yo',
      'yy',
      'Description.',
      'foo',
      'bar',
      'yo_yo.drush.inc',
    ];
    $this->target = 'yo_yo.drush.inc';
    $this->fixture = __DIR__ . '/_drush_command.inc';
    parent::setUp();
  }

}
