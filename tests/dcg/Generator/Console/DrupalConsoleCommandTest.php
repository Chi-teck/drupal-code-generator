<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Tests\Generator\Console;

use DrupalCodeGenerator\Tests\Generator\BaseGeneratorTest;

/**
 * Test for console:drupal-console-command command.
 */
final class DrupalConsoleCommandTest extends BaseGeneratorTest {

  protected $class = 'Console\DrupalConsoleCommand';

  protected $interaction = [
    'Module name [%default_name%]:' => 'Foo',
    'Module machine name [foo]:' => 'foo',
    'Command name [foo:example]:' => 'foo:example',
    'Command description [Command description.]:' => 'Command description.',
    'Make the command aware of the Drupal site installation? [Yes]:' => 'no',
  ];

  protected $fixtures = [
    'console.services.yml' => '/_drupal_console_command_services.yml',
    'src/Command/FooExampleCommand.php' => '/_drupal_console_command.php',
  ];

}
