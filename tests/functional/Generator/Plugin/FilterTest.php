<?php

declare(strict_types=1);

namespace DrupalCodeGenerator\Tests\Functional\Generator\Plugin;

use DrupalCodeGenerator\Command\Plugin\Filter;
use DrupalCodeGenerator\Test\Functional\GeneratorTestBase;

/**
 * Tests plugin:filter generator.
 */
final class FilterTest extends GeneratorTestBase {

  protected string $fixtureDir = __DIR__ . '/_filter';

  /**
   * Test callback.
   */
  public function testWithDependenciesAndWithConfiguration(): void {
    $input = [
      'foo',
      'Foo',
      'Example',
      'foo_example',
      'Example',
      '1',
      'Yes',
      'Yes',
      'entity_type.manager',
      '',
    ];
    $this->execute(Filter::class, $input);

    $expected_display = <<< 'TXT'

     Welcome to filter generator!
    ––––––––––––––––––––––––––––––

     Module machine name:
     ➤ 

     Module name [Foo]:
     ➤ 

     Plugin label:
     ➤ 

     Plugin ID [foo_example]:
     ➤ 

     Plugin class [Example]:
     ➤ 

     Filter type:
      [1] HTML restrictor
      [2] Markup language
      [3] Irreversible transformation
      [4] Reversible transformation
     ➤ 

     Make the filter configurable? [No]:
     ➤ 

     Would you like to inject dependencies? [No]:
     ➤ 

     Type the service name or use arrows up/down. Press enter to continue:
     ➤ 

     Type the service name or use arrows up/down. Press enter to continue:
     ➤ 

     The following directories and files have been created or updated:
    –––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
     • foo.info.yml
     • config/schema/foo.schema.yml
     • src/Plugin/Filter/Example.php

    TXT;
    $this->assertDisplay($expected_display);

    $this->assertGeneratedFile('config/schema/foo.schema.yml', '_w_deps/_w_config/config/schema/foo.schema.yml');
    $this->assertGeneratedFile('src/Plugin/Filter/Example.php', '_w_deps/_w_config/src/Plugin/Filter/Example.php');
  }

  /**
   * Test callback.
   */
  public function testWithoutDependenciesAndWithoutConfiguration(): void {
    $input = [
      'foo',
      'Foo',
      'Example',
      'foo_example',
      'Example',
      '2',
      'No',
      'No',
    ];
    $this->execute(Filter::class, $input);

    $expected_display = <<< 'TXT'

     Welcome to filter generator!
    ––––––––––––––––––––––––––––––

     Module machine name:
     ➤ 

     Module name [Foo]:
     ➤ 

     Plugin label:
     ➤ 

     Plugin ID [foo_example]:
     ➤ 

     Plugin class [Example]:
     ➤ 

     Filter type:
      [1] HTML restrictor
      [2] Markup language
      [3] Irreversible transformation
      [4] Reversible transformation
     ➤ 

     Make the filter configurable? [No]:
     ➤ 

     Would you like to inject dependencies? [No]:
     ➤ 

     The following directories and files have been created or updated:
    –––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
     • foo.info.yml
     • src/Plugin/Filter/Example.php

    TXT;
    $this->assertDisplay($expected_display);

    $this->assertGeneratedFile('src/Plugin/Filter/Example.php', '_n_deps/_n_config/src/Plugin/Filter/Example.php');
  }

}
