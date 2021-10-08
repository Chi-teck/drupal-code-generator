<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Tests\Generator;

/**
 * Test for install-file command.
 */
final class InstallFileTest extends BaseGeneratorTest {

  protected string $class = 'InstallFile';

  protected array $interaction = [
    'Module name [%default_name%]:' => 'Foo',
    'Module machine name [foo]:' => 'foo',
  ];

  protected array $fixtures = [
    'foo.install' => '/_.install',
  ];

}
