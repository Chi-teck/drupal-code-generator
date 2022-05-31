<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Tests\Functional\Generator;

use DrupalCodeGenerator\Command\Template;
use DrupalCodeGenerator\Test\Functional\GeneratorTestBase;

/**
 * Tests template generator.
 */
final class TemplateTest extends GeneratorTestBase {

  protected string $fixtureDir = __DIR__ . '/_template';

  public function testGenerator(): void {

    $user_input = ['example', 'foo', 'Yes', 'Yes'];
    $this->execute(Template::class, $user_input);

    $expected_display = <<< 'TXT'

     Welcome to template generator!
    ––––––––––––––––––––––––––––––––

     Module machine name:
     ➤ 

     Template name [example]:
     ➤ 

     Create theme hook? [Yes]:
     ➤ 

     Create preprocess hook? [Yes]:
     ➤ 

     The following directories and files have been created or updated:
    –––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
     • example.module
     • templates/foo.html.twig

    TXT;
    $this->assertDisplay($expected_display);

    $this->assertGeneratedFile('example.module');
    $this->assertGeneratedFile('templates/foo.html.twig');
  }

}
