<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Tests\Functional\Generator\Plugin;

use DrupalCodeGenerator\Command\Plugin\Block;
use DrupalCodeGenerator\Test\Functional\GeneratorTestBase;

/**
 * Tests plugin:block generator.
 */
final class BlockTest extends GeneratorTestBase {

  protected string $fixtureDir = __DIR__ . '/_block';

  public function testGenerator(): void {
    $input = [
      'foo',
      'Example',
      'foo_example',
      'ExampleBlock',
      'Custom',
      'Yes',
      'Yes',
      'cron',
      '',
      'Yes',
    ];
    $this->execute(Block::class, $input);

    $expected_display = <<< 'TXT'

     Welcome to block generator!
    –––––––––––––––––––––––––––––

     Module machine name:
     ➤ 

     Block admin label:
     ➤ 

     Plugin ID [foo_example]:
     ➤ 

     Plugin class [ExampleBlock]:
     ➤ 

     Block category [Custom]:
     ➤ 

     Make the block configurable? [No]:
     ➤ 

     Would you like to inject dependencies? [No]:
     ➤ 

     Type the service name or use arrows up/down. Press enter to continue:
     ➤ 

     Type the service name or use arrows up/down. Press enter to continue:
     ➤ 

     Create access callback? [No]:
     ➤ 

     The following directories and files have been created or updated:
    –––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
     • config/schema/foo.schema.yml
     • src/Plugin/Block/ExampleBlock.php

    TXT;
    $this->assertDisplay($expected_display);

    $this->assertGeneratedFile('config/schema/foo.schema.yml');
    $this->assertGeneratedFile('src/Plugin/Block/ExampleBlock.php');
  }

}
