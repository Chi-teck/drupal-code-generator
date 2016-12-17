<?php

namespace DrupalCodeGenerator\Tests\Drupal_8\Yml;

use DrupalCodeGenerator\Tests\GeneratorTestCase;

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
