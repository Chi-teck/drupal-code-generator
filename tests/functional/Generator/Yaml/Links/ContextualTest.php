<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Tests\Functional\Generator\Yaml\Links;

use DrupalCodeGenerator\Command\Yml\Links\Contextual;
use DrupalCodeGenerator\Test\Functional\GeneratorTestBase;

/**
 * Tests yml:links:contextual generator.
 */
class ContextualTest extends GeneratorTestBase {

  protected string $fixtureDir = __DIR__ . '/_contextual';

  public function testGenerator(): void {

    $this->execute(Contextual::class, ['example']);

    $expected_display = <<< 'TXT'

     Welcome to contextual-links generator!
    ––––––––––––––––––––––––––––––––––––––––

     Module machine name:
     ➤ 

     The following directories and files have been created or updated:
    –––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
     • example.links.contextual.yml

    TXT;
    $this->assertDisplay($expected_display);

    $this->assertGeneratedFile('example.links.contextual.yml');
  }

}
