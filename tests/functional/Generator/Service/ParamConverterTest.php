<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Tests\Functional\Generator\Service;

use DrupalCodeGenerator\Command\Service\ParamConverter;
use DrupalCodeGenerator\Test\Functional\GeneratorTestBase;

/**
 * Tests service:param-converter generator.
 */
final class ParamConverterTest extends GeneratorTestBase {

  protected string $fixtureDir = __DIR__ . '/_param_converter';

  /**
   * Test callback.
   */
  public function testWithoutDependencies(): void {
    $input = [
      'example',
      'foo',
      'FooParamConverter',
      'No',
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

     Would you like to inject dependencies? [Yes]:
     ➤ 

     The following directories and files have been created or updated:
    –––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
     • example.info.yml
     • example.services.yml
     • src/FooParamConverter.php

    TXT;
    $this->assertDisplay($expected_display);

    $this->assertGeneratedFile('example.services.yml', '_n_deps/example.services.yml');
    $this->assertGeneratedFile('src/FooParamConverter.php', '_n_deps/src/FooParamConverter.php');
  }

  /**
   * Test callback.
   */
  public function testWithDependencies(): void {
    $input = [
      'example',
      'foo',
      'FooParamConverter',
      'Yes',
      'entity_type.manager',
      '',
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

     Would you like to inject dependencies? [Yes]:
     ➤ 

     Type the service name or use arrows up/down. Press enter to continue:
     ➤ 

     Type the service name or use arrows up/down. Press enter to continue:
     ➤ 

     The following directories and files have been created or updated:
    –––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
     • example.info.yml
     • example.services.yml
     • src/FooParamConverter.php

    TXT;
    $this->assertDisplay($expected_display);

    $this->assertGeneratedFile('example.services.yml', '_w_deps/example.services.yml');
    $this->assertGeneratedFile('src/FooParamConverter.php', '_w_deps/src/FooParamConverter.php');
  }

  /**
   * Test callback.
   */
  public function testParamTypeValidator(): void {
    $input = [
      'example',
      'wrong type',
      'correct:type',
      'FooParamConverter',
      'No',
    ];
    $this->execute(ParamConverter::class, $input);

    $expected_display = <<< 'TXT'

     Welcome to param-converter generator!
    –––––––––––––––––––––––––––––––––––––––

     Module machine name:
     ➤ 

     Parameter type [example]:
     ➤  The value does not match pattern "/^[a-z][a-z0-9_\:]*[a-z0-9]$/".

     Parameter type [example]:
     ➤ 

     Class [CorrectTypeParamConverter]:
     ➤ 

     Would you like to inject dependencies? [Yes]:
     ➤ 

     The following directories and files have been created or updated:
    –––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
     • example.info.yml
     • example.services.yml
     • src/FooParamConverter.php

    TXT;
    $this->assertDisplay($expected_display);
  }

}
