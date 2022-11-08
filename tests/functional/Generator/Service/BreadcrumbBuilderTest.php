<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Tests\Generator\Service;

use DrupalCodeGenerator\Command\Service\BreadcrumbBuilder;
use DrupalCodeGenerator\Test\Functional\GeneratorTestBase;

/**
 * Tests breadcrumb-builder generator.
 */
final class BreadcrumbBuilderTest extends GeneratorTestBase {

  protected string $fixtureDir = __DIR__ . '/_breadcrumb_builder';

  /**
   * Test callback.
   */
  public function testWithoutDependencies(): void {
    $input = [
      'example',
      'ExampleBreadcrumbBuilder',
      'No',
    ];
    $this->execute(BreadcrumbBuilder::class, $input);

    $expected_display = <<< 'TXT'

     Welcome to breadcrumb-builder generator!
    ––––––––––––––––––––––––––––––––––––––––––

     Module machine name:
     ➤ 

     Class [ExampleBreadcrumbBuilder]:
     ➤ 

     Would you like to inject dependencies? [Yes]:
     ➤ 

     The following directories and files have been created or updated:
    –––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
     • example.services.yml
     • src/ExampleBreadcrumbBuilder.php

    TXT;
    $this->assertDisplay($expected_display);

    $this->assertGeneratedFile('example.services.yml', '_n_deps/example.services.yml');
    $this->assertGeneratedFile('src/ExampleBreadcrumbBuilder.php', '_n_deps/src/ExampleBreadcrumbBuilder.php');
  }

  /**
   * Test callback.
   */
  public function testWithDependencies(): void {
    $input = [
      'example',
      'ExampleBreadcrumbBuilder',
      'Yes',
      'cron',
      '',
    ];
    $this->execute(BreadcrumbBuilder::class, $input);

    $expected_display = <<< 'TXT'

     Welcome to breadcrumb-builder generator!
    ––––––––––––––––––––––––––––––––––––––––––

     Module machine name:
     ➤ 

     Class [ExampleBreadcrumbBuilder]:
     ➤ 

     Would you like to inject dependencies? [Yes]:
     ➤ 

     Type the service name or use arrows up/down. Press enter to continue:
     ➤ 

     Type the service name or use arrows up/down. Press enter to continue:
     ➤ 

     The following directories and files have been created or updated:
    –––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
     • example.services.yml
     • src/ExampleBreadcrumbBuilder.php

    TXT;
    $this->assertDisplay($expected_display);

    $this->assertGeneratedFile('example.services.yml', '_w_deps/example.services.yml');
    $this->assertGeneratedFile('src/ExampleBreadcrumbBuilder.php', '_w_deps/src/ExampleBreadcrumbBuilder.php');
  }

}
