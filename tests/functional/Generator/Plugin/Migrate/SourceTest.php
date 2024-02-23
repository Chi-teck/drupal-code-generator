<?php

declare(strict_types=1);

namespace DrupalCodeGenerator\Tests\Functional\Generator\Plugin\Migrate;

use DrupalCodeGenerator\Command\Plugin\Migrate\Source;
use DrupalCodeGenerator\Test\Functional\GeneratorTestBase;

/**
 * Tests plugin:migrate:source generator.
 */
final class SourceTest extends GeneratorTestBase {

  protected string $class = 'Plugin\Migrate\Source';

  protected string $fixtureDir = __DIR__ . '/_source';

  /**
   * Test callback.
   */
  public function testSqlSourceGenerator(): void {
    $input = [
      'example',
      'example_foo',
      'Foo',
      'SQL',
    ];
    $this->execute(Source::class, $input);

    $expected_display = <<< 'TXT'

     Welcome to migrate-source generator!
    ––––––––––––––––––––––––––––––––––––––

     Module machine name:
     ➤ 

     Plugin ID:
     ➤ 

     Plugin class [Foo]:
     ➤ 

     Source type:
      [1] SQL
      [2] Other
     ➤ 

     The following directories and files have been created or updated:
    –––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
     • example.info.yml
     • src/Plugin/migrate/source/Foo.php

    TXT;
    $this->assertDisplay($expected_display);

    $this->fixtureDir .= '/_w_sql';
    $this->assertGeneratedFile('src/Plugin/migrate/source/Foo.php');
  }

  /**
   * Test callback.
   */
  public function testOtherSourceGenerator(): void {
    $input = [
      'example',
      'example_bar',
      'Bar',
      'Other',
    ];
    $this->execute(Source::class, $input);

    $expected_display = <<< 'TXT'

     Welcome to migrate-source generator!
    ––––––––––––––––––––––––––––––––––––––

     Module machine name:
     ➤ 

     Plugin ID:
     ➤ 

     Plugin class [Bar]:
     ➤ 

     Source type:
      [1] SQL
      [2] Other
     ➤ 

     The following directories and files have been created or updated:
    –––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
     • example.info.yml
     • src/Plugin/migrate/source/Bar.php

    TXT;
    $this->assertDisplay($expected_display);

    $this->fixtureDir .= '/_n_sql';
    $this->assertGeneratedFile('src/Plugin/migrate/source/Bar.php');
  }

}
