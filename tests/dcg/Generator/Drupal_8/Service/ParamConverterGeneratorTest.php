<?php

namespace DrupalCodeGenerator\Tests\Generator\Drupal_8\Service;

use DrupalCodeGenerator\Tests\Generator\BaseGeneratorTest;

/**
 * Test for service:param-converter command.
 */
class ParamConverterGeneratorTest extends BaseGeneratorTest {

  protected $class = 'Service\ParamConverter';

  protected $interaction = [
    'Module name [%default_name%]:' => 'Example',
    'Module machine name [example]:' => 'example',
    'Parameter type [example]:' => 'foo',
    'Class [FooParamConverter]:' => 'FooParamConverter',
  ];

  protected $fixtures = [
    'example.services.yml' => __DIR__ . '/_param_converter.services.yml',
    'src/FooParamConverter.php' => __DIR__ . '/_param_converter.php',
  ];

}
