<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Tests\Functional\Generator\Plugin;

use DrupalCodeGenerator\Command\Plugin\MenuLink;
use DrupalCodeGenerator\Test\Functional\GeneratorTestBase;

/**
 * Tests plugin:menu-link generator.
 */
final class MenuLinkTest extends GeneratorTestBase {

  protected string $fixtureDir = __DIR__ . '/_menu_link';

  /**
   * Test callback.
   */
  public function testWithoutDependencies(): void {
    $input = [
      'example',
      'FooMenuLink',
      'No',
    ];
    $this->execute(MenuLink::class, $input);

    $expected_display = <<< 'TXT'

     Welcome to menu-link generator!
    –––––––––––––––––––––––––––––––––

     Module machine name:
     ➤ 

     Class [ExampleMenuLink]:
     ➤ 

     Would you like to inject dependencies? [No]:
     ➤ 

     The following directories and files have been created or updated:
    –––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
     • src/Plugin/Menu/FooMenuLink.php

    TXT;
    $this->assertDisplay($expected_display);

    $this->assertGeneratedFile('src/Plugin/Menu/FooMenuLink.php', '_n_deps/src/Plugin/Menu/FooMenuLink.php');
  }

  /**
   * Test callback.
   */
  public function testWithDependencies(): void {
    $input = [
      'example',
      'FooMenuLink',
      'Yes',
      'menu.active_trail',
      '',
    ];
    $this->execute(MenuLink::class, $input);

    $expected_display = <<< 'TXT'

     Welcome to menu-link generator!
    –––––––––––––––––––––––––––––––––

     Module machine name:
     ➤ 

     Class [ExampleMenuLink]:
     ➤ 

     Would you like to inject dependencies? [No]:
     ➤ 

     Type the service name or use arrows up/down. Press enter to continue:
     ➤ 

     Type the service name or use arrows up/down. Press enter to continue:
     ➤ 

     The following directories and files have been created or updated:
    –––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
     • src/Plugin/Menu/FooMenuLink.php

    TXT;
    $this->assertDisplay($expected_display);

    $this->assertGeneratedFile('src/Plugin/Menu/FooMenuLink.php', '_w_deps/src/Plugin/Menu/FooMenuLink.php');
  }

}
