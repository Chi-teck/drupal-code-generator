<?php

namespace DrupalCodeGenerator\Tests\Generator\Drupal_8;

use DrupalCodeGenerator\Tests\Generator\GeneratorTestCase;

/**
 * Test for d8:install command.
 */
class InstallTest extends GeneratorTestCase {

  protected $class = 'Drupal_8\Install';

  protected $answers = [
    'Foo',
    'foo',
  ];

  protected $fixtures = [
    'foo.install' => __DIR__ . '/_.install',
  ];

}
