<?php

namespace DrupalCodeGenerator\Tests\Drupal_8\Component\Plugin;

use DrupalCodeGenerator\Tests\GeneratorTestCase;
use DrupalCodeGenerator\Commands\Drupal_8\Component\Plugin\Filter;

class FilterTest extends GeneratorTestCase {

  /**
   * {@inheritdoc}
   */
  public function setUp () {
    $this->command = new Filter();
    $this->commandName = 'generate:d8:component:plugin:filter';
    $this->answers = [
      'Filter example',
      'filter_example',
      'Example of filter plugin.',
      'filter_example',
    ];
    $this->target = 'FilterExample.php';
    $this->fixture = __DIR__ . '/_' . $this->target;

    parent::setUp();
  }

}
