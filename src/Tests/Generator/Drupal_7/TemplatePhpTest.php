<?php

namespace DrupalCodeGenerator\Tests\Generator\Drupal_7;

use DrupalCodeGenerator\Tests\Generator\GeneratorTestCase;

/**
 * Test for d7:template.php command.
 */
class TemplatePhpTest extends GeneratorTestCase {

  protected $class = 'Drupal_7\TemplatePhp';

  protected $answers = [
    'Example',
    'example',
  ];

  protected $fixtures = [
    'template.php' => __DIR__ . '/_template.php',
  ];

}
