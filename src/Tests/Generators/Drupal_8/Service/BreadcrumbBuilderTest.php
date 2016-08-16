<?php

namespace DrupalCodeGenerator\Tests\Drupal_8\Service;

use DrupalCodeGenerator\Tests\GeneratorTestCase;

/**
 * Test for d8:service:breadcrumb-builder command.
 */
class BreadcrumbBuilderTest extends GeneratorTestCase {

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    $this->class = 'Drupal_8\Service\BreadcrumbBuilder';
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
