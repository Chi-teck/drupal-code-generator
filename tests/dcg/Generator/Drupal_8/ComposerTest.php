<?php

namespace DrupalCodeGenerator\Tests\Generator\Drupal_8;

use DrupalCodeGenerator\Tests\Generator\GeneratorBaseTest;

/**
 * Test for d8:composer command.
 */
class ComposerTest extends GeneratorBaseTest {

  protected $class = 'Drupal_8\Composer';

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
