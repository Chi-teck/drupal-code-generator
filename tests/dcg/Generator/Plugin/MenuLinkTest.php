<?php

namespace DrupalCodeGenerator\Tests\Generator\Plugin;

use DrupalCodeGenerator\Tests\Generator\BaseGeneratorTest;

/**
 * Test for plugin:menu-link command.
 */
class MenuLinkTest extends BaseGeneratorTest {

  protected $class = 'Plugin\MenuLink';

  protected $interaction = [
    'Module name [%default_name%]:' => 'Example',
    'Module machine name [example]:' => 'example',
    'Class [ExampleMenuLink]:' => 'FooMenuLink',
  ];

  protected $fixtures = [
    'src/Plugin/Menu/FooMenuLink.php' => '/_menu_link.php',
  ];

}
