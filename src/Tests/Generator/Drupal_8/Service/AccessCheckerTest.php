<?php

namespace DrupalCodeGenerator\Tests\Generator\Drupal_8\Service;

use DrupalCodeGenerator\Tests\Generator\GeneratorTestCase;

/**
 * Test for d8:service:access-checker command.
 */
class AccessCheckerTest extends GeneratorTestCase {

  protected $class = 'Drupal_8\Service\AccessChecker';

  protected $answers = [
    'Example',
    'example',
    'foo',
    'FooAccessChecker',
  ];

  protected $fixtures = [
    'src/Access/FooAccessChecker.php' => __DIR__ . '/_access_checker.php',
    'example.services.yml' => __DIR__ . '/_access_checker.services.yml',
  ];

}
