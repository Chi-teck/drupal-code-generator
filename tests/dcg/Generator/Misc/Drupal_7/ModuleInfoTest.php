<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Tests\Generator\Misc\Drupal_7;

use DrupalCodeGenerator\Tests\Generator\BaseGeneratorTest;

/**
 * Test for misc:d7:module-info command.
 */
final class ModuleInfoTest extends BaseGeneratorTest {

  protected string $class = 'Misc\Drupal_7\ModuleInfo';

  protected array $interaction = [
    'Module name [%default_name%]:' => 'Example',
    'Module machine name [example]:' => 'example',
    'Module description [Module description.]:' => 'Some description.',
    'Package [Custom]:' => 'Custom',
  ];

  protected array $fixtures = [
    'example.info' => '/_module.info',
  ];

}
