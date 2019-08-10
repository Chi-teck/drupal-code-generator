<?php

namespace DrupalCodeGenerator\Tests\Generator\Console;

use DrupalCodeGenerator\Tests\Generator\BaseGeneratorTest;

/**
 * Test for console:symfony-command command.
 */
class SymfonyCommandTest extends BaseGeneratorTest {

  protected $class = 'Console\SymfonyCommand';

  protected $interaction = [
    'Module name [%default_name%]:' => 'Foo',
    'Module machine name [foo]:' => 'foo',
    'Command name [foo:example]:' => 'foo:bar',
    'Command description:' => 'Example command.',
    'Command alias [bar]:' => 'bar',
    'Class [BarCommand]:' => 'BarCommand',
    'Would you like to run the command with Drush [Yes]:' => 'Yes',
  ];

  protected $fixtures = [
    'drush.services.yml' => '/_symfony_command_services.yml',
    'src/Command/BarCommand.php' => '/_symfony_command.php',
  ];

}
