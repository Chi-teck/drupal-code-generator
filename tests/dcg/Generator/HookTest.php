<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Tests\Generator;

/**
 * Test for hook command.
 */
final class HookTest extends BaseGeneratorTest {

  protected string $class = 'Hook';

  protected array $interaction = [
    'Module name [%default_name%]:' => 'Example',
    'Module machine name [example]:' => 'example',
    'Hook name:' => 'theme',
  ];

  protected array $fixtures = [
    'example.module' => '/_hook.module',
  ];

}
