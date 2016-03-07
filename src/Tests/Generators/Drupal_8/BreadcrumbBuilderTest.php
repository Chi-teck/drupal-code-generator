<?php

namespace DrupalCodeGenerator\Tests\Drupal_8;

use DrupalCodeGenerator\Tests\GeneratorTestCase;

/**
 * Test for d8:breadcrumb-builder command.
 */
class BreadcrumbBuilderTest extends GeneratorTestCase {

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    $this->class = 'Drupal_8\BreadcrumbBuilder';
    $this->answers = [
      'Example',
      'example',
      'ExampleBreadcrumbBuilder',
    ];
    $this->target = 'ExampleBreadcrumbBuilder.php';
    $this->fixture = __DIR__ . '/_breadcrumb_builder.php';

    parent::setUp();
  }

}
