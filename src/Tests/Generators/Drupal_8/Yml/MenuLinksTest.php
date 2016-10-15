<?php

namespace DrupalCodeGenerator\Tests\Drupal_8\Yml;

use DrupalCodeGenerator\Tests\GeneratorTestCase;

/**
 * Test for d8:yml:menu-links command.
 */
class MenuLinksTest extends GeneratorTestCase {

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    $this->class = 'Drupal_8\Yml\MenuLinks';
    $this->answers = [
      'example',
    ];
    $this->target = 'example.links.menu.yml';
    $this->fixture = __DIR__ . '/_links.menu.yml';

    parent::setUp();
  }

}
