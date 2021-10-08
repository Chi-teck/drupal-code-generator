<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Tests\Generator\Service;

use DrupalCodeGenerator\Tests\Generator\BaseGeneratorTest;

/**
 * Test for service:param-converter command.
 */
final class ParamConverterTest extends BaseGeneratorTest {

  protected string $class = 'Service\ParamConverter';

  protected array $interaction = [
    'Module name [%default_name%]:' => 'Example',
    'Module machine name [example]:' => 'example',
    'Parameter type [example]:' => 'foo',
    'Class [FooParamConverter]:' => 'FooParamConverter',
  ];

  protected array $fixtures = [
    'example.services.yml' => '/_param_converter.services.yml',
    'src/FooParamConverter.php' => '/_param_converter.php',
  ];

}
