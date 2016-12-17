<?php

namespace DrupalCodeGenerator\Tests\Drupal_8;

use DrupalCodeGenerator\Tests\GeneratorTestCase;

/**
 * Test for d8:controller command.
 */
class ControllerTest extends GeneratorTestCase {

  protected $class = 'Drupal_8\Controller';

  protected $answers = [
    'Example',
    'example',
    'ExampleController',
  ];

  protected $fixtures = [
    'src/Controller/ExampleController.php' => __DIR__ . '/_controller.php',
  ];

}
