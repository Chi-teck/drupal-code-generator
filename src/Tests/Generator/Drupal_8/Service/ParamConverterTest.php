<?php

namespace DrupalCodeGenerator\Tests\Generator\Drupal_8\Service;

use DrupalCodeGenerator\Tests\Generator\GeneratorTestCase;

/**
 * Test for d8:service:param-converter command.
 */
class ParamConverterTest extends GeneratorTestCase {

  protected $class = 'Drupal_8\Service\ParamConverter';

  protected $answers = [
    'Example',
    'example',
    'foo',
    'FooParamConverter',
  ];

  protected $fixtures = [
    'src/FooParamConverter.php' => __DIR__ . '/_param_converter.php',
    'example.services.yml' => __DIR__ . '/_param_converter.services.yml',
  ];

}
