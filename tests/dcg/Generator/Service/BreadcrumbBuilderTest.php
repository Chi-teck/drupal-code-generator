<?php

namespace DrupalCodeGenerator\Tests\Generator\Service;

use DrupalCodeGenerator\Tests\Generator\BaseGeneratorTest;

/**
 * Test for service:breadcrumb-builder command.
 */
final class BreadcrumbBuilderTest extends BaseGeneratorTest {

  protected $class = 'Service\BreadcrumbBuilder';

  protected $interaction = [
    'Module name [%default_name%]:' => 'Example',
    'Module machine name [example]:' => 'example',
    'Class [ExampleBreadcrumbBuilder]:' => 'ExampleBreadcrumbBuilder',
  ];

  protected $fixtures = [
    'example.services.yml' => '/_breadcrumb.services.yml',
    'src/ExampleBreadcrumbBuilder.php' => '/_breadcrumb_builder.php',
  ];

}
