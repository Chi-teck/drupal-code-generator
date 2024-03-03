<?php

declare(strict_types=1);

namespace DrupalCodeGenerator\Tests\Functional\Generator;

use DrupalCodeGenerator\Command\Hook;
use DrupalCodeGenerator\Test\Functional\GeneratorTestBase;

/**
 * Tests hook generator.
 */
final class HookTest extends GeneratorTestBase {

  protected string $fixtureDir = __DIR__ . '/_hook';

  public function testGenerator(): void {
    if (\str_starts_with(\getenv('DCG_DRUPAL_VERSION') ?: '', '10.1')) {
      self::markTestSkipped();
    }
    $this->execute(Hook::class, ['example', 'Example', 'theme']);

    $expected_display = <<< 'TXT'

     Welcome to hook generator!
    ––––––––––––––––––––––––––––

     Module machine name:
     ➤ 

     Module name [Example]:
     ➤ 

     Hook name:
     ➤ 

     The following directories and files have been created or updated:
    –––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
     • example.info.yml
     • example.module

    TXT;
    $this->assertDisplay($expected_display);

    $this->assertGeneratedFile('example.module');
  }

  public function testHookNameValidation(): void {
    $input = [
      'example',
      'Example',
      NULL,
      'wrong',
      'theme',
    ];
    $this->execute(Hook::class, $input);

    $expected_display = <<< 'TXT'

     Welcome to hook generator!
    ––––––––––––––––––––––––––––

     Module machine name:
     ➤ 

     Module name [Example]:
     ➤ 

     Hook name:
     ➤  The value is required.

     Hook name:
     ➤  The value is not correct hook name.

     Hook name:
     ➤ 

     The following directories and files have been created or updated:
    –––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
     • example.info.yml
     • example.module

    TXT;
    $this->assertDisplay($expected_display);
  }

}
