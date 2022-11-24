<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Tests\Functional\Generator\Plugin;

use DrupalCodeGenerator\Command\Plugin\Condition;
use DrupalCodeGenerator\Test\Functional\GeneratorTestBase;

/**
 * Tests plugin:condition generator.
 */
final class ConditionTest extends GeneratorTestBase {

  protected string $fixtureDir = __DIR__ . '/_condition';

  /**
   * Test callback.
   */
  public function testWithoutDependencies(): void {
    $input = [
      'foo',
      'Example',
      'foo_example',
      'Example',
      'No',
    ];
    $this->execute(Condition::class, $input);

    $expected_display = <<< 'TXT'

     Welcome to condition generator!
    –––––––––––––––––––––––––––––––––

     Module machine name:
     ➤ 

     Plugin label:
     ➤ 

     Plugin ID [foo_example]:
     ➤ 

     Plugin class [Example]:
     ➤ 

     Would you like to inject dependencies? [No]:
     ➤ 

     The following directories and files have been created or updated:
    –––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
     • config/schema/foo.schema.yml
     • src/Plugin/Condition/Example.php

    TXT;
    $this->assertDisplay($expected_display);

    $this->assertGeneratedFile('config/schema/foo.schema.yml', '_n_deps/config/schema/foo.schema.yml');
    $this->assertGeneratedFile('src/Plugin/Condition/Example.php', '_n_deps/src/Plugin/Condition/Example.php');
  }

  /**
   * Test callback.
   */
  public function testWithDependencies(): void {
    $input = [
      'foo',
      'Example',
      'foo_example',
      'Example',
      'Yes',
      'cron',
      '',
    ];
    $this->execute(Condition::class, $input);

    $expected_display = <<< 'TXT'

     Welcome to condition generator!
    –––––––––––––––––––––––––––––––––

     Module machine name:
     ➤ 

     Plugin label:
     ➤ 

     Plugin ID [foo_example]:
     ➤ 

     Plugin class [Example]:
     ➤ 

     Would you like to inject dependencies? [No]:
     ➤ 

     Type the service name or use arrows up/down. Press enter to continue:
     ➤ 

     Type the service name or use arrows up/down. Press enter to continue:
     ➤ 

     The following directories and files have been created or updated:
    –––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
     • config/schema/foo.schema.yml
     • src/Plugin/Condition/Example.php

    TXT;
    $this->assertDisplay($expected_display);

    $this->assertGeneratedFile('config/schema/foo.schema.yml', '_w_deps/config/schema/foo.schema.yml');
    $this->assertGeneratedFile('src/Plugin/Condition/Example.php', '_w_deps/src/Plugin/Condition/Example.php');
  }

}
