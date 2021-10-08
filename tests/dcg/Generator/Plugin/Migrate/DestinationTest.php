<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Tests\Generator\Plugin\Migrate;

use DrupalCodeGenerator\Tests\Generator\BaseGeneratorTest;

/**
 * Test for plugin:migrate:destination command.
 */
final class DestinationTest extends BaseGeneratorTest {

  protected string $class = 'Plugin\Migrate\Destination';

  protected array $interaction = [
    'Module name [%default_name%]:' => 'Example',
    'Module machine name [example]:' => 'example',
    'Plugin ID [example_example]:' => 'example_bar',
    'Plugin class [Bar]:' => 'Bar',
  ];

  protected array $fixtures = [
    'src/Plugin/migrate/destination/Bar.php' => '/_destination.php',
  ];

}
