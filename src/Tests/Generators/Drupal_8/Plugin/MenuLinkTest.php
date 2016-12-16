<?php

namespace DrupalCodeGenerator\Tests\Drupal_8\Plugin;

use DrupalCodeGenerator\Tests\GeneratorTestCase;

/**
 * Test for d8:plugin:menu-link command.
 */
class MenuLinkTest extends GeneratorTestCase {

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    $this->class = 'Drupal_8\Plugin\MenuLink';
    $this->answers = [
      'Example',
      'example',
      'FooMenuLink',
    ];
    $this->target = 'src/Plugin/Menu/FooMenuLink.php';
    $this->fixture = __DIR__ . '/_menu_link.php';

    parent::setUp();
  }

}
