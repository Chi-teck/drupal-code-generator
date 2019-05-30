<?php

namespace DrupalCodeGenerator\Tests\Generator;

/**
 * Test for module-file command.
 */
class ModuleFileTest extends BaseGeneratorTest {

  protected $class = 'ModuleFile';

  protected $interaction = [
    'Module name [%default_name%]:' => 'Foo',
    'Module machine name [foo]:' => 'foo',
  ];

  protected $fixtures = [
    'foo.module' => '/_module_file.module',
  ];

}
