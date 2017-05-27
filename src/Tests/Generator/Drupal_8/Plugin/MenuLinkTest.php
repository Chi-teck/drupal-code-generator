<?php

namespace DrupalCodeGenerator\Tests\Generator\Drupal_8\Plugin;

use DrupalCodeGenerator\Tests\Generator\GeneratorTestCase;

/**
 * Test for d8:plugin:menu-link command.
 */
class MenuLinkTest extends GeneratorTestCase {

  protected $class = 'Drupal_8\Plugin\MenuLink';

  protected $answers = [
    'Example',
    'example',
    'FooMenuLink',
  ];

  protected $fixtures = [
    'src/Plugin/Menu/FooMenuLink.php' => __DIR__ . '/_menu_link.php',
  ];

}
