<?php

namespace DrupalCodeGenerator\Tests\Generator\Console;

use DrupalCodeGenerator\Tests\Generator\BaseGeneratorTest;

/**
 * Test for console:drupal-console-command command.
 */
class DrupalConsoleCommandTest extends BaseGeneratorTest {

  protected $class = 'Console\DrupalConsoleCommand';

  protected $interaction = [
    'Module name [%default_name%]:' => 'Foo',
    'Module machine name [foo]:' => 'foo',
    'Command name [foo:example]:' => 'foo:example',
    'Command description [Command description.]:' => 'Command description.',
    'Make the command aware of the drupal site installation? [Yes]:' => 'no',
  ];

  protected $fixtures = [
    'src/Command/FooExampleCommand.php' => __DIR__ . '/_drupal_console_command.php',
  ];

}
