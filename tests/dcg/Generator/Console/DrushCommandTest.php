<?php

namespace DrupalCodeGenerator\Tests\Generator\console;

use DrupalCodeGenerator\Tests\Generator\BaseGeneratorTest;

/**
 * Test for console:drush-command command.
 */
class DrushCommandTest extends BaseGeneratorTest {

  protected $class = 'Console\DrushCommand';

  protected $interaction = [
    'Command name:' => 'yo-yo',
    'Command alias [yo-]:' => 'yy',
    'Command description [Command description.]:' => 'Description.',
    'Argument name [foo]:' => 'foo',
    'Option name [bar]:' => 'bar',
    'Command file [%default_machine_name%.drush.inc]:' => 'yo_yo.drush.inc',
  ];

  protected $fixtures = [
    'yo_yo.drush.inc' => '/_drush_command.inc',
  ];

}
