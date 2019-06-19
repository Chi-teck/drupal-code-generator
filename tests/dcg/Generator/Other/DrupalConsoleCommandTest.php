<?php

namespace DrupalCodeGenerator\Tests\Other;

use DrupalCodeGenerator\Tests\Generator\GeneratorBaseTest;

/**
 * Test for other:drupal-console-command command.
 */
class DrupalConsoleCommandTest extends GeneratorBaseTest {

  protected $class = 'Other\DrupalConsoleCommand';

  protected $interaction = [
    'Module name [%default_name%]:' => 'Foo',
    'Module machine name [foo]:' => 'foo',
    'Command name [foo:example]:' => 'foo:example',
    'Command description [Command description.]:' => 'Command description.',
    'Make the command aware of the drupal site installation? [Yes]:' => 'no',
  ];

  protected $fixtures = [
    'console.services.yml' => __DIR__ . '/_drupal_console_command_services.yml',
    'src/Command/FooExampleCommand.php' => __DIR__ . '/_drupal_console_command.php',
  ];

}
