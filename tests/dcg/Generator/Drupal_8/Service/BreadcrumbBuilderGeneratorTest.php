<?php

namespace DrupalCodeGenerator\Tests\Generator\Drupal_8\Service;

use DrupalCodeGenerator\Tests\Generator\BaseGeneratorTest;

/**
 * Test for service:breadcrumb-builder command.
 */
class BreadcrumbBuilderGeneratorTest extends BaseGeneratorTest {

  protected $class = 'Service\BreadcrumbBuilder';

  protected $interaction = [
    'Module name [%default_name%]:' => 'Example',
    'Module machine name [example]:' => 'example',
    'Class [ExampleBreadcrumbBuilder]:' => 'ExampleBreadcrumbBuilder',
  ];

  protected $fixtures = [
    'example.services.yml' => __DIR__ . '/_breadcrumb.services.yml',
    'src/ExampleBreadcrumbBuilder.php' => __DIR__ . '/_breadcrumb_builder.php',
  ];

}
