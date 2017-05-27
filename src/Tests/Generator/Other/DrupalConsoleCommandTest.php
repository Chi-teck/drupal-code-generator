<?php

namespace DrupalCodeGenerator\Tests\Other;

use DrupalCodeGenerator\Tests\Generator\GeneratorTestCase;

/**
 * Test for other:drupal-console-command command.
 */
class DrupalConsoleCommandTest extends GeneratorTestCase {

  protected $class = 'Other\DrupalConsoleCommand';

  protected $answers = [
    'Foo',
    'foo',
    'foo:example',
    'Command description.',
    FALSE,
  ];

  protected $fixtures = [
    'src/Command/FooExampleCommand.php' => __DIR__ . '/_drupal_console_command.php',
  ];

}
