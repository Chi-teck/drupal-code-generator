<?php

namespace DrupalCodeGenerator\Tests\Generator\Drupal_8\Yml\Links;

use DrupalCodeGenerator\Tests\Generator\BaseGeneratorTest;

/**
 * Test for yml:menu:links command.
 */
class MenuLinksGeneratorTest extends BaseGeneratorTest {

  protected $class = 'Yml\Links\Menu';

  protected $interaction = [
    'Module machine name [%default_machine_name%]:' => 'example',
  ];

  protected $fixtures = [
    'example.links.menu.yml' => __DIR__ . '/_links.menu.yml',
  ];

}
