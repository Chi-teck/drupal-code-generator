<?php

namespace DrupalCodeGenerator\Tests\Generator;

/**
 * Test for composer command.
 */
class ComposerTest extends BaseGeneratorTest {

  protected $class = 'Composer';

  protected $interaction = [
    'Project machine name [%default_machine_name%]:' => 'example',
    'Description:' => 'Example description.',
    'Type [drupal-module]:' => 'drupal-module',
    'Is this project hosted on drupal.org? [No]:' => 'Yes',
  ];

  protected $fixtures = [
    'composer.json' => __DIR__ . '/_composer.json',
  ];

}
