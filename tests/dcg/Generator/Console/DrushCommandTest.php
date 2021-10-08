<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Tests\Generator\Console;

use DrupalCodeGenerator\Tests\Generator\BaseGeneratorTest;

/**
 * Test for console:drush-command command.
 */
final class DrushCommandTest extends BaseGeneratorTest {

  protected string $class = 'Console\DrushCommand';

  protected array $interaction = [
    'Command name:' => 'yo-yo',
    'Command alias [yo-]:' => 'yy',
    'Command description [Command description.]:' => 'Description.',
    'Argument name [foo]:' => 'foo',
    'Option name [bar]:' => 'bar',
    'Command file [%default_machine_name%.drush.inc]:' => 'yo_yo.drush.inc',
  ];

  protected array $fixtures = [
    'yo_yo.drush.inc' => '/_drush_command.inc',
  ];

}
