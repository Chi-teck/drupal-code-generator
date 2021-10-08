<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Tests\Generator\Misc\Drupal_7;

use DrupalCodeGenerator\Tests\Generator\BaseGeneratorTest;

/**
 * Test for misc:d7:hook command.
 */
final class HookTest extends BaseGeneratorTest {

  protected string $class = 'Misc\Drupal_7\Hook';

  protected array $interaction = [
    'Module name [%default_name%]:' => 'Example',
    'Module machine name [example]:' => 'example',
    'Hook name:' => 'init',
  ];

  protected array $fixtures = [
    'example.module' => '/_hook.module',
  ];

}
