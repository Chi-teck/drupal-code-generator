<?php

namespace DrupalCodeGenerator\Tests\Drupal_8\Plugin;

use DrupalCodeGenerator\Tests\GeneratorTestCase;

/**
 * Test for d8:plugin:filter command.
 */
class FilterTest extends GeneratorTestCase {

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    $this->class = 'Drupal_8\Plugin\Filter';
    $this->answers = [
      'Filter example',
      'filter_example',
      'Example of filter plugin.',
      'filter_example',
    ];
    $this->target = 'FilterExample.php';
    $this->fixture = __DIR__ . '/_filter.php';

    parent::setUp();
  }

}
