<?php

declare(strict_types=1);

namespace DrupalCodeGenerator\Tests\Functional\Generator;

use DrupalCodeGenerator\Command\Batch;
use DrupalCodeGenerator\Test\Functional\GeneratorTestBase;

/**
 * Tests batch generator.
 */
final class BatchTest extends GeneratorTestBase {

  protected string $fixtureDir = __DIR__ . '/_batch';

  /**
   * Test callback.
   */
  public function testGenerator(): void {
    $input = [
      'example',
      'ExampleBatch',
      'processItem',
      'finished',
    ];
    $this->execute(Batch::class, $input);

    $expected_display = <<< 'TXT'

     Welcome to batch generator!
    –––––––––––––––––––––––––––––
    
     Module machine name:
     ➤ 

     Class [ExampleBatch]:
     ➤ 

     Operation callback method name [processItem]:
     ➤ 

     Finished callback method name [finished]:
     ➤ 

     The following directories and files have been created or updated:
    –––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
     • example.info.yml
     • src/ExampleBatch.php

    TXT;

    $this->assertDisplay($expected_display);

    $this->assertGeneratedFile('src/ExampleBatch.php');
  }

}
