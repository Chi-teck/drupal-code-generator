<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Tests\Generator;

/**
 * Test for module-file command.
 */
final class ModuleFileTest extends BaseGeneratorTest {

  protected string $class = 'ModuleFile';

  protected array $interaction = [
    'Module name [%default_name%]:' => 'Foo',
    'Module machine name [foo]:' => 'foo',
  ];

  protected array $fixtures = [
    'foo.module' => '/_module_file.module',
  ];

}
