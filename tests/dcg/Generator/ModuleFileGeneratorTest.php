<?php

namespace DrupalCodeGenerator\Tests\Generator;

/**
 * Test for module-file command.
 */
class ModuleFileGeneratorTest extends BaseGeneratorTest {

  protected $class = 'ModuleFile';

  protected $interaction = [
    'Module name [%default_name%]:' => 'Foo',
    'Module machine name [foo]:' => 'foo',
  ];

  protected $fixtures = [
    'foo.module' => __DIR__ . '/_module_file.module',
  ];

}
