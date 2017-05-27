<?php

namespace DrupalCodeGenerator\Tests\Generator\Drupal_8\Yml;

use DrupalCodeGenerator\Tests\Generator\GeneratorTestCase;

/**
 * Test for d8:yml:menu-links command.
 */
class MenuLinksTest extends GeneratorTestCase {

  protected $class = 'Drupal_8\Yml\MenuLinks';

  protected $answers = ['example'];

  protected $fixtures = [
    'example.links.menu.yml' => __DIR__ . '/_links.menu.yml',
  ];

}
