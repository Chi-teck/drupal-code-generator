<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Tests\Functional\Generator\Yaml\Links;

use DrupalCodeGenerator\Command\Yml\Links\Menu;
use DrupalCodeGenerator\Test\Functional\GeneratorTestBase;

/**
 * Tests yml:menu:links generator.
 */
class MenuTest extends GeneratorTestBase {

  protected string $fixtureDir = __DIR__ . '/_menu';

  public function testGenerator(): void {

    $this->execute(Menu::class, ['example']);

    $expected_display = <<< 'TXT'

     Welcome to menu-links generator!
    ––––––––––––––––––––––––––––––––––

     Module machine name:
     ➤ 

     The following directories and files have been created or updated:
    –––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
     • example.info.yml
     • example.links.menu.yml

    TXT;
    $this->assertDisplay($expected_display);

    $this->assertGeneratedFile('example.links.menu.yml');
  }

}
