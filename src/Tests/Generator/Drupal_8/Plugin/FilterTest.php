<?php

namespace DrupalCodeGenerator\Tests\Generator\Drupal_8\Plugin;

use DrupalCodeGenerator\Tests\Generator\GeneratorTestCase;

/**
 * Test for d8:plugin:filter command.
 */
class FilterTest extends GeneratorTestCase {

  protected $class = 'Drupal_8\Plugin\Filter';

  protected $answers = [
    'Foo',
    'foo',
    'Example',
    'filter_example',
  ];

  protected $fixtures = [
    'src/Plugin/Filter/Example.php' => __DIR__ . '/_filter.php',
  ];

}
