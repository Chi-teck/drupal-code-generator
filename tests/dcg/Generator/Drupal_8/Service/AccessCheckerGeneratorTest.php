<?php

namespace DrupalCodeGenerator\Tests\Generator\Drupal_8\Service;

use DrupalCodeGenerator\Tests\Generator\BaseGeneratorTest;

/**
 * Test for service:access-checker command.
 */
class AccessCheckerGeneratorTest extends BaseGeneratorTest {

  protected $class = 'Service\AccessChecker';

  protected $interaction = [
    'Module name [%default_name%]:' => 'Example',
    'Module machine name [example]:' => 'example',
    'Applies to [_foo]:' => '_foo',
    'Class [FooAccessChecker]:' => 'FooAccessChecker',
  ];

  protected $fixtures = [
    'example.services.yml' => __DIR__ . '/_access_checker.services.yml',
    'src/Access/FooAccessChecker.php' => __DIR__ . '/_access_checker.php',
  ];

}
