<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Tests\Generator\Yml;

use DrupalCodeGenerator\Tests\Generator\BaseGeneratorTest;

/**
 * Test for yml:module-info command.
 */
final class ModuleInfoTest extends BaseGeneratorTest {

  protected string $class = 'Yml\ModuleInfo';

  protected array $interaction = [
    'Module name [%default_name%]:' => 'Example',
    'Module machine name [example]:' => 'example',
    'Description [Module description.]:' => 'Example description.',
    'Package [Custom]:' => 'Custom',
    'Configuration page (route name):' => 'example.settings',
    'Dependencies (comma separated):' => 'views, node, fields',
  ];

  protected array $fixtures = [
    'example.info.yml' => '/_module_info.yml',
  ];

}
