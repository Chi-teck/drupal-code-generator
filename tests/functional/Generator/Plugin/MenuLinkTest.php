<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Tests\Functional\Generator\Plugin;

use DrupalCodeGenerator\Command\Plugin\MenuLink;
use DrupalCodeGenerator\Test\Functional\GeneratorTestBase;

/**
 * Tests plugin:menu-link generator.
 */
final class MenuLinkTest extends GeneratorTestBase {

  protected string $fixtureDir = __DIR__ . '/_menu_link';

  public function testGenerator(): void {
    $input = [
      'example',
      'FooMenuLink',
    ];
    $this->execute(MenuLink::class, $input);

    $expected_display = <<< 'TXT'

     Welcome to menu-link generator!
    –––––––––––––––––––––––––––––––––

     Module machine name:
     ➤ 

     Class [ExampleMenuLink]:
     ➤ 

     The following directories and files have been created or updated:
    –––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
     • src/Plugin/Menu/FooMenuLink.php

    TXT;
    $this->assertDisplay($expected_display);

    $this->assertGeneratedFile('src/Plugin/Menu/FooMenuLink.php');
  }

}
