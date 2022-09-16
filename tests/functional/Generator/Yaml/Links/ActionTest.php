<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Tests\Functional\Generator\Yaml\Links;

use DrupalCodeGenerator\Command\Yml\Links\Action;
use DrupalCodeGenerator\Test\Functional\GeneratorTestBase;

/**
 * Tests yml:links:action generator.
 */
class ActionTest extends GeneratorTestBase {

  protected string $fixtureDir = __DIR__ . '/_action';

  public function testGenerator(): void {

    $this->execute(Action::class, ['foo']);

    $expected_display = <<< 'TXT'

     Welcome to action-links generator!
    ––––––––––––––––––––––––––––––––––––

     Module machine name:
     ➤ 

     The following directories and files have been created or updated:
    –––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
     • foo.links.action.yml

    TXT;
    $this->assertDisplay($expected_display);

    $this->assertGeneratedFile('foo.links.action.yml');
  }

}
