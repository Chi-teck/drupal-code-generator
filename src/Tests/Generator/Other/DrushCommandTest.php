<?php

namespace DrupalCodeGenerator\Tests\Other;

use DrupalCodeGenerator\Tests\Generator\GeneratorTestCase;

/**
 * Test for other:drush-command command.
 */
class DrushCommandTest extends GeneratorTestCase {

  protected $class = 'Other\DrushCommand';

  protected $answers = [
    'yo-yo',
    'yy',
    'Description.',
    'foo',
    'bar',
    'yo_yo.drush.inc',
  ];

  protected $fixtures = [
    'yo_yo.drush.inc' => __DIR__ . '/_drush_command.inc',
  ];

}
