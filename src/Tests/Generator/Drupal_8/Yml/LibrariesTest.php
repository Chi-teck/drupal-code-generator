<?php

namespace DrupalCodeGenerator\Tests\Generator\Drupal_8\Yml;

use DrupalCodeGenerator\Tests\Generator\GeneratorTestCase;

/**
 * Test for d8:yml:libraries command.
 *
 * @TODO: Split it into two separate tests for module and theme.
 */
class LibrariesTest extends GeneratorTestCase {

  protected $class = 'Drupal_8\Yml\Libraries';
  protected $answers = [
    'Example',
    'example',
    'module',
  ];
  protected $fixtures = [
    'example.libraries.yml' => __DIR__ . '/_libraries.yml',
  ];

}
