<?php

namespace DrupalCodeGenerator\Tests\Generator\Drupal_7;

use DrupalCodeGenerator\Tests\Generator\GeneratorBaseTest;

/**
 * Test for d7:template.php command.
 */
class TemplatePhpTest extends GeneratorBaseTest {

  protected $class = 'Drupal_7\TemplatePhp';

  protected $interaction = [
    'Theme name [%default_name%]: ' => 'Example',
    'Theme machine name [example]: ' => 'example',
  ];

  protected $fixtures = [
    'template.php' => __DIR__ . '/_template.php',
  ];

}
