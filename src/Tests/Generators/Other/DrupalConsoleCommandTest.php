<?php

namespace DrupalCodeGenerator\Tests\Other;

use DrupalCodeGenerator\Tests\GeneratorTestCase;

/**
 * Test for other:drupal-console-command command.
 */
class DrupalConsoleCommandTest extends GeneratorTestCase {

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    $this->class = 'Other\DrupalConsoleCommand';
    $this->answers = [
      'foo',
      'foo:example',
      'Command description.',
      FALSE,
    ];
    $this->target = 'FooExampleCommand.php';
    $this->fixture = __DIR__ . '/_drupal_console_command.php';
    parent::setUp();
  }

}
