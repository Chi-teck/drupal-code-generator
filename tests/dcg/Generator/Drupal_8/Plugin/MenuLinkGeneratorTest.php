<?php

namespace DrupalCodeGenerator\Tests\Generator\Drupal_8\Plugin;

use DrupalCodeGenerator\Tests\Generator\BaseGeneratorTest;

/**
 * Test for d8:plugin:menu-link command.
 */
class MenuLinkGeneratorTest extends BaseGeneratorTest {

  protected $class = 'Drupal_8\Plugin\MenuLink';

  protected $interaction = [
    'Module name [%default_name%]:' => 'Example',
    'Module machine name [example]:' => 'example',
    'Class [ExampleMenuLink]:' => 'FooMenuLink',
  ];

  protected $fixtures = [
    'src/Plugin/Menu/FooMenuLink.php' => __DIR__ . '/_menu_link.php',
  ];

}
