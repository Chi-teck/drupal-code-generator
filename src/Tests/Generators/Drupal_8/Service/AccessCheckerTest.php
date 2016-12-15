<?php

namespace DrupalCodeGenerator\Tests\Drupal_8\Service;

use DrupalCodeGenerator\Tests\GeneratorTestCase;

/**
 * Test for d8:service:access-checker command.
 */
class AccessCheckerTest extends GeneratorTestCase {

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    $this->class = 'Drupal_8\Service\AccessChecker';
    $this->answers = [
      'Example',
      'example',
      'foo',
      'FooAccessChecker',
    ];
    $this->target = 'FooAccessChecker.php';
    $this->fixture = __DIR__ . '/_access_checker.php';

    parent::setUp();
  }

}
