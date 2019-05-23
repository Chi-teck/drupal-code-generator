<?php

namespace DrupalCodeGenerator\Tests\Generator\Yml;

use DrupalCodeGenerator\Tests\Generator\BaseGeneratorTest;

/**
 * Test for yml:services command.
 */
class ServicesGeneratorTest extends BaseGeneratorTest {

  protected $class = 'Yml\Services';

  protected $interaction = [
    'Module name [%default_name%]:' => 'Foo',
    'Module machine name [foo]:' => 'foo',
  ];
  protected $fixtures = [
    'foo.services.yml' => __DIR__ . '/_services.yml',
  ];

}
