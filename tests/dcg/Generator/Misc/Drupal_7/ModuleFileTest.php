<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Tests\Generator\Misc\Drupal_7;

use DrupalCodeGenerator\Tests\Generator\BaseGeneratorTest;

/**
 * Test for misc:d7:module-file command.
 */
final class ModuleFileTest extends BaseGeneratorTest {

  protected string $class = 'Misc\Drupal_7\ModuleFile';

  protected array $interaction = [
    'Module name [%default_name%]:' => 'Example',
    'Module machine name [example]:' => 'example',
  ];

  protected array $fixtures = [
    'example.module' => '/_.module',
  ];

}
