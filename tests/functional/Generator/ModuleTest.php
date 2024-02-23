<?php

declare(strict_types=1);

namespace DrupalCodeGenerator\Tests\Functional\Generator;

use DrupalCodeGenerator\Command\Module;
use DrupalCodeGenerator\Test\Functional\GeneratorTestBase;

/**
 * Tests module generator.
 */
final class ModuleTest extends GeneratorTestBase {

  protected string $fixtureDir = __DIR__ . '/_module';

  /**
   * Test callback.
   */
  public function testGenerator(): void {

    $input = [
      'Foo',
      'foo',
      'Some description.',
      'Custom',
      'drupal:views',
      'Yes',
      'Yes',
      'Yes',
    ];
    $this->execute(Module::class, $input);

    $expected_display = <<< 'TXT'

     Welcome to module generator!
    ––––––––––––––––––––––––––––––

     Module name:
     ➤ 

     Module machine name [foo]:
     ➤ 

     Module description:
     ➤ 

     Package [Custom]:
     ➤ 

     Dependencies (comma separated):
     ➤ 

     Would you like to create module file? [No]:
     ➤ 

     Would you like to create install file? [No]:
     ➤ 

     Would you like to create README.md file? [No]:
     ➤ 

     The following directories and files have been created or updated:
    –––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
     • foo/foo.info.yml
     • foo/foo.install
     • foo/foo.module
     • foo/README.md

    TXT;
    $this->assertDisplay($expected_display);

    $this->assertGeneratedFile('foo/foo.info.yml');
    $this->assertGeneratedFile('foo/foo.install');
    $this->assertGeneratedFile('foo/foo.module');
    $this->assertGeneratedFile('foo/README.md');
  }

  /**
   * Test callback.
   */
  public function testDependencyNormalizer(): void {
    $input = [
      'Bar',
      'bar',
      'Some description.',
      'Custom',
      'system,drupal:views, alpha,beta, Gamma, Node, Space Inside',
      'No',
      'No',
      'No',
    ];
    $this->execute(Module::class, $input);
    $this->assertGeneratedFile('bar/bar.info.yml');
  }

}
