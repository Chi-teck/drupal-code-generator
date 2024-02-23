<?php

declare(strict_types=1);

namespace DrupalCodeGenerator\Tests\Functional\Generator\Plugin;

use DrupalCodeGenerator\Command\Plugin\Action;
use DrupalCodeGenerator\Test\Functional\GeneratorTestBase;

/**
 * Tests plugin:action generator.
 */
final class ActionTest extends GeneratorTestBase {

  protected string $fixtureDir = __DIR__ . '/_action';

  /**
   * Test callback.
   */
  public function testWithoutDepsAndWithConfig(): void {
    $input = [
      'example',
      'Foo',
      'example_foo',
      'Foo',
      'Custom',
      'node',
      'yes',
      'No',
    ];
    $this->execute(Action::class, $input);

    $expected_display = <<< 'TXT'

     Welcome to action generator!
    ––––––––––––––––––––––––––––––

     Module machine name:
     ➤ 

     Action label:
     ➤ 

     Plugin ID [example_foo]:
     ➤ 

     Plugin class [Foo]:
     ➤ 

     Action category [Custom]:
     ➤ 

     Entity type to apply the action [node]:
     ➤ 

     Make the action configurable? [No]:
     ➤ 

     Would you like to inject dependencies? [No]:
     ➤ 

     The following directories and files have been created or updated:
    –––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
     • example.info.yml
     • config/schema/example.schema.yml
     • src/Plugin/Action/Foo.php

    TXT;
    $this->assertDisplay($expected_display);

    $this->fixtureDir .= '/_n_deps/_w_config';
    $this->assertGeneratedFile('config/schema/example.schema.yml');
    $this->assertGeneratedFile('src/Plugin/Action/Foo.php');
  }

  /**
   * Test callback.
   */
  public function testWithDepsAndWithoutConfig(): void {
    $input = [
      'example',
      'Foo',
      'example_foo',
      'Foo',
      'My Actions',
      'user',
      'No',
      'Yes',
      'flood',
      '',
    ];
    $this->execute(Action::class, $input);

    $expected_display = <<< 'TXT'

     Welcome to action generator!
    ––––––––––––––––––––––––––––––

     Module machine name:
     ➤ 

     Action label:
     ➤ 

     Plugin ID [example_foo]:
     ➤ 

     Plugin class [Foo]:
     ➤ 

     Action category [Custom]:
     ➤ 

     Entity type to apply the action [node]:
     ➤ 

     Make the action configurable? [No]:
     ➤ 

     Would you like to inject dependencies? [No]:
     ➤ 

     Type the service name or use arrows up/down. Press enter to continue:
     ➤ 

     Type the service name or use arrows up/down. Press enter to continue:
     ➤ 

     The following directories and files have been created or updated:
    –––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
     • example.info.yml
     • src/Plugin/Action/Foo.php

    TXT;
    $this->assertDisplay($expected_display);

    $this->fixtureDir .= '/_w_deps/_n_config';
    $this->assertGeneratedFile('src/Plugin/Action/Foo.php');
  }

}
