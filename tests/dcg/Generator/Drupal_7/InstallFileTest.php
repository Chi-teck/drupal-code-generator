<?php

namespace DrupalCodeGenerator\Tests\Generator\Drupal_7;

use DrupalCodeGenerator\Tests\Generator\GeneratorBaseTest;

/**
 * Test for d7:install-file command.
 */
class InstallFileTest extends GeneratorBaseTest {

  protected $class = 'Drupal_7\InstallFile';

  protected $interaction = [
    'Module name [%default_name%]:' => 'Example',
    'Module machine name [example]:' => 'example',
  ];

  protected $fixtures = [
    'example.install' => __DIR__ . '/_.install',
  ];

}
