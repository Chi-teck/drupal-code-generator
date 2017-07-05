<?php

namespace DrupalCodeGenerator\Tests\Generator\Drupal_8\Yml;

use DrupalCodeGenerator\Tests\Generator\GeneratorBaseTest;

/**
 * Test for d8:yml:menu-links command.
 */
class MenuLinksTest extends GeneratorBaseTest {

  protected $class = 'Drupal_8\Yml\MenuLinks';

  protected $interaction = [
    'Module machine name [%default_machine_name%]: ' => 'example',
  ];

  protected $fixtures = [
    'example.links.menu.yml' => __DIR__ . '/_links.menu.yml',
  ];

}
