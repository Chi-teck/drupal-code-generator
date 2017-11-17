<?php

namespace DrupalCodeGenerator\Tests\Generator\Drupal_8;

use DrupalCodeGenerator\Tests\Generator\GeneratorBaseTest;

/**
 * Test for d8:install command.
 */
class InstallTest extends GeneratorBaseTest {

  protected $class = 'Drupal_8\Install';

  protected $interaction = [
    'Module name [%default_name%]:' => 'Foo',
    'Module machine name [foo]:' => 'foo',
  ];

  protected $fixtures = [
    'foo.install' => __DIR__ . '/_.install',
  ];

}
