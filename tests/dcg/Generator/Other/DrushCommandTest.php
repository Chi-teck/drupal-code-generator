<?php

namespace DrupalCodeGenerator\Tests\Other;

use DrupalCodeGenerator\Tests\Generator\GeneratorBaseTest;

/**
 * Test for other:drush-command command.
 */
class DrushCommandTest extends GeneratorBaseTest {

  protected $class = 'Other\DrushCommand';

  protected $interaction = [
    'Command name: ' => 'yo-yo',
    'Command alias [yo-]: ' => 'yy',
    'Command description [Command description.]: ' => 'Description.',
    'Argument name [foo]: ' => 'foo',
    'Option name [bar]: ' => 'bar',
    'Command file [%default_machine_name%.drush.inc]: ' => 'yo_yo.drush.inc',
  ];

  protected $fixtures = [
    'yo_yo.drush.inc' => __DIR__ . '/_drush_command.inc',
  ];

}
