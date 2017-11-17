<?php

namespace DrupalCodeGenerator\Tests\Generator\Drupal_8\Service;

use DrupalCodeGenerator\Tests\Generator\GeneratorBaseTest;

/**
 * Test for d8:service:param-converter command.
 */
class ParamConverterTest extends GeneratorBaseTest {

  protected $class = 'Drupal_8\Service\ParamConverter';

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
