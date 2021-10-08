<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Tests\Generator;

/**
 * Test for install-file command.
 */
final class InstallFileTest extends BaseGeneratorTest {

  protected $class = 'InstallFile';

  protected $interaction = [
    'Module name [%default_name%]:' => 'Foo',
    'Module machine name [foo]:' => 'foo',
  ];

  protected $fixtures = [
    'foo.install' => '/_.install',
  ];

}
