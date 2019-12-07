<?php

namespace DrupalCodeGenerator\Tests\Generator\Drupal_8\Service;

use DrupalCodeGenerator\Tests\Generator\GeneratorBaseTest;

/**
 * Test for d8:service:path-processor command.
 */
class PathProcessorTest extends GeneratorBaseTest {

  protected $class = 'Drupal_8\Service\PathProcessor';

  protected $interaction = [
    'Module name [%default_name%]:' => 'Example',
    'Module machine name [example]:' => 'example',
    'Class [PathProcessorExample]:' => 'PathProcessorExample',
  ];

  protected $fixtures = [
    'example.services.yml' => __DIR__ . '/_path_processor.services.yml',
    'src/PathProcessor/PathProcessorExample.php' => __DIR__ . '/_path_processor.php',
  ];

}
