<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Tests\Generator\Misc\Drupal_7;

use DrupalCodeGenerator\Tests\Generator\BaseGeneratorTest;

/**
 * Test for misc:d7:module command.
 */
final class ModuleTest extends BaseGeneratorTest {

  protected $class = 'Misc\Drupal_7\Module';

  protected $interaction = [
    'Module name [%default_name%]:' => 'Example',
    'Module machine name [example]:' => 'example',
    'Module description [Module description.]:' => 'Some description.',
    'Package [Custom]:' => 'Custom',
  ];

  protected $fixtures = [
    'example/example.admin.inc' => '/_module/example.admin.inc',
    'example/example.info' => '/_module/example.info',
    'example/example.install' => '/_module/example.install',
    'example/example.js' => '/_module/example.js',
    'example/example.module' => '/_module/example.module',
    'example/example.pages.inc' => '/_module/example.pages.inc',
  ];

}
