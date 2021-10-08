<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Tests\Generator\Service;

use DrupalCodeGenerator\Tests\Generator\BaseGeneratorTest;

/**
 * Test for service:path-processor command.
 */
final class PathProcessorTest extends BaseGeneratorTest {

  protected string $class = 'Service\PathProcessor';

  protected array $interaction = [
    'Module name [%default_name%]:' => 'Example',
    'Module machine name [example]:' => 'example',
    'Class [PathProcessorExample]:' => 'PathProcessorExample',
  ];

  protected array $fixtures = [
    'example.services.yml' => '/_path_processor.services.yml',
    'src/PathProcessor/PathProcessorExample.php' => '/_path_processor.php',
  ];

}
