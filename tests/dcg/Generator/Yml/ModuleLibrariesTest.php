<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Tests\Generator\Yml;

use DrupalCodeGenerator\Tests\Generator\BaseGeneratorTest;

/**
 * Test for yml:module-libraries command.
 */
final class ModuleLibrariesTest extends BaseGeneratorTest {

  protected string $class = 'Yml\ModuleLibraries';

  protected array $interaction = [
    'Module machine name [%default_machine_name%]:' => 'example',
  ];

  protected array $fixtures = [
    'example.libraries.yml' => '/_module_libraries.yml',
  ];

}
