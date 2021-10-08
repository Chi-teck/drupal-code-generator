<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Tests\Generator\Plugin;

use DrupalCodeGenerator\Tests\Generator\BaseGeneratorTest;

/**
 * Test for plugin:menu-link command.
 */
final class MenuLinkTest extends BaseGeneratorTest {

  protected string $class = 'Plugin\MenuLink';

  protected array $interaction = [
    'Module name [%default_name%]:' => 'Example',
    'Module machine name [example]:' => 'example',
    'Class [ExampleMenuLink]:' => 'FooMenuLink',
  ];

  protected array $fixtures = [
    'src/Plugin/Menu/FooMenuLink.php' => '/_menu_link.php',
  ];

}
