<?php

namespace DrupalCodeGenerator\Tests\Generator\Drupal_8\Yml;

use DrupalCodeGenerator\Tests\Generator\GeneratorTestCase;

/**
 * Test for d8:yml:action-links command.
 */
class ActionLinksTest extends GeneratorTestCase {

  protected $class = 'Drupal_8\Yml\ActionLinks';

  protected $answers = ['example'];

  protected $fixtures = [
    'example.links.action.yml' => __DIR__ . '/_links.action.yml',
  ];

}
