<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Tests\Generator\Yml;

use DrupalCodeGenerator\Tests\Generator\BaseGeneratorTest;

/**
 * Test for yml:theme-libraries command.
 */
final class ThemeLibrariesTest extends BaseGeneratorTest {

  protected string $class = 'Yml\ThemeLibraries';

  protected array $interaction = [
    'Theme machine name [%default_machine_name%]:' => 'example',
  ];

  protected array $fixtures = [
    'example.libraries.yml' => '/_theme_libraries.yml',
  ];

}
