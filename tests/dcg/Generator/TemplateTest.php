<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Tests\Generator;

use DrupalCodeGenerator\Command\Template;
use DrupalCodeGenerator\Test\GeneratorTest;

/**
 * Test for template command.
 */
final class TemplateTest extends GeneratorTest {

  protected string $fixtureDir = __DIR__;

  /**
   * Test callback.
   */
  public function testGenerator(): void {

    $user_input = ['Example', 'example', 'foo', 'Yes', 'Yes'];
    $this->execute(new Template(), $user_input);

    $expected_display = <<< 'TXT'

     Welcome to template generator!
    ––––––––––––––––––––––––––––––––

     Module name [%default_name%]:
     ➤ 

     Module machine name [example]:
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

    $this->assertGeneratedFile('example.module', '_template.module');
    $this->assertGeneratedFile('templates/foo.html.twig', '_template.twig');
  }

}
