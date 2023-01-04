<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Tests\Functional\Generator\Plugin\Field;

use DrupalCodeGenerator\Command\Plugin\Field\Formatter;
use DrupalCodeGenerator\Test\Functional\GeneratorTestBase;

/**
 * Tests plugin:field:formatter generator.
 */
final class FormatterTest extends GeneratorTestBase {

  protected string $fixtureDir = __DIR__ . '/_formatter';

  /**
   * Test callback.
   */
  public function testWithConfig(): void {
    $input = [
      'foo',
      'Zoo',
      'foo_zoo',
      'ZooFormatter',
      'Yes',
    ];
    $this->execute(Formatter::class, $input);

    $expected_display = <<< 'TXT'

     Welcome to field-formatter generator!
    –––––––––––––––––––––––––––––––––––––––

     Module machine name:
     ➤ 

     Plugin label:
     ➤ 

     Plugin ID [foo_zoo]:
     ➤ 

     Plugin class [ZooFormatter]:
     ➤ 

     Make the formatter configurable? [No]:
     ➤ 

     The following directories and files have been created or updated:
    –––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
     • config/schema/foo.schema.yml
     • src/Plugin/Field/FieldFormatter/ZooFormatter.php

    TXT;
    $this->assertDisplay($expected_display);

    $this->fixtureDir .= '/_w_config';
    $this->assertGeneratedFile('config/schema/foo.schema.yml');
    $this->assertGeneratedFile('src/Plugin/Field/FieldFormatter/ZooFormatter.php');
  }

  /**
   * Test callback.
   */
  public function testWithoutConfig(): void {
    $input = [
      'foo',
      'Zoo',
      'foo_zoo',
      'ZooFormatter',
      'No',
    ];
    $this->execute(Formatter::class, $input);

    $expected_display = <<< 'TXT'

     Welcome to field-formatter generator!
    –––––––––––––––––––––––––––––––––––––––

     Module machine name:
     ➤ 

     Plugin label:
     ➤ 

     Plugin ID [foo_zoo]:
     ➤ 

     Plugin class [ZooFormatter]:
     ➤ 

     Make the formatter configurable? [No]:
     ➤ 

     The following directories and files have been created or updated:
    –––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
     • src/Plugin/Field/FieldFormatter/ZooFormatter.php

    TXT;
    $this->assertDisplay($expected_display);

    $this->fixtureDir .= '/_n_config';
    $this->assertGeneratedFile('src/Plugin/Field/FieldFormatter/ZooFormatter.php');
  }

}
