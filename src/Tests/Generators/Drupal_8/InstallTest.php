<?php

namespace DrupalCodeGenerator\Tests\Drupal_8;

use DrupalCodeGenerator\Tests\GeneratorTestCase;

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
