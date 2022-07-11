<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Tests\Functional\Generator\Service;

use DrupalCodeGenerator\Command\Service\ParamConverter;
use DrupalCodeGenerator\Test\Functional\GeneratorTestBase;

/**
 * Tests service:param-converter generator.
 */
final class ParamConverterTest extends GeneratorTestBase {

  protected string $fixtureDir = __DIR__ . '/_param_converter';

  public function testGenerator(): void {
    $input = [
      'example',
      'foo',
      'FooParamConverter',
    ];
    $this->execute(ParamConverter::class, $input);

    $expected_display = <<< 'TXT'

     Welcome to param-converter generator!
    –––––––––––––––––––––––––––––––––––––––

     Module machine name:
     ➤ 

     Parameter type [example]:
     ➤ 

     Class [FooParamConverter]:
     ➤ 

     The following directories and files have been created or updated:
    –––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
     • example.services.yml
     • src/FooParamConverter.php

    TXT;
    $this->assertDisplay($expected_display);

    $this->assertGeneratedFile('example.services.yml');
    $this->assertGeneratedFile('src/FooParamConverter.php');
  }

}
