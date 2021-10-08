<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Tests\Generator\Misc\Drupal_7;

use DrupalCodeGenerator\Tests\Generator\BaseGeneratorTest;

/**
 * Test for misc:d7:settings.php command.
 */
final class SettingsTest extends BaseGeneratorTest {

  protected string $class = 'Misc\Drupal_7\Settings';

  protected array $interaction = [
    'Database driver [mysql]:' => 'mysql',
    'Database name [drupal]:' => 'drupal',
    'Database user [root]:' => 'root',
    'Database password [123]:' => '123',
  ];

  protected array $fixtures = [
    'settings.php' => '/_settings.php',
  ];

}
