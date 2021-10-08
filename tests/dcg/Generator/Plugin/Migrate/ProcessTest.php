<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Tests\Generator\Plugin\Migrate;

use DrupalCodeGenerator\Tests\Generator\BaseGeneratorTest;

/**
 * Test for plugin:migrate:process command.
 */
final class ProcessTest extends BaseGeneratorTest {

  protected $class = 'Plugin\Migrate\Process';

  protected $interaction = [
    'Module name [%default_name%]:' => 'Example',
    'Module machine name [example]:' => 'example',
    'Plugin ID [example_example]:' => 'example_qux',
    'Plugin class [Qux]:' => 'Qux',
  ];

  protected $fixtures = [
    'src/Plugin/migrate/process/Qux.php' => '/_process.php',
  ];

}
