<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Tests\Generator\Service;

use DrupalCodeGenerator\Command\Service\BreadcrumbBuilder;
use DrupalCodeGenerator\Test\Functional\GeneratorTestBase;

/**
 * Tests breadcrumb-builder generator.
 */
final class BreadcrumbBuilderTest extends GeneratorTestBase {

  protected string $fixtureDir = __DIR__ . '/_breadcrumb_builder';

  public function testGenerator(): void {

    $this->execute(BreadcrumbBuilder::class, ['example', 'ExampleBreadcrumbBuilder']);

    $expected_display = <<< 'TXT'

     Welcome to breadcrumb-builder generator!
    ––––––––––––––––––––––––––––––––––––––––––

     Module machine name:
     ➤ 

     Class [ExampleBreadcrumbBuilder]:
     ➤ 

     The following directories and files have been created or updated:
    –––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
     • example.services.yml
     • src/ExampleBreadcrumbBuilder.php

    TXT;
    $this->assertDisplay($expected_display);

    $this->assertGeneratedFile('example.services.yml');
    $this->assertGeneratedFile('src/ExampleBreadcrumbBuilder.php');
  }

}
