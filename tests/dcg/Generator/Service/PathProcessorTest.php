<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Tests\Generator\Service;

use DrupalCodeGenerator\Tests\Generator\BaseGeneratorTest;

/**
 * Test for service:path-processor command.
 */
final class PathProcessorTest extends BaseGeneratorTest {

  protected $class = 'Service\PathProcessor';

  protected $interaction = [
    'Module name [%default_name%]:' => 'Example',
    'Module machine name [example]:' => 'example',
    'Class [PathProcessorExample]:' => 'PathProcessorExample',
  ];

  protected $fixtures = [
    'example.services.yml' => '/_path_processor.services.yml',
    'src/PathProcessor/PathProcessorExample.php' => '/_path_processor.php',
  ];

}
