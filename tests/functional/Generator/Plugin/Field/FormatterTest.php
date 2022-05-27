<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Tests\Functional\Generator\Plugin\Field;

use DrupalCodeGenerator\Command\Plugin\Field\Formatter;
use DrupalCodeGenerator\Test\Functional\GeneratorTestBase;

/**
 * Tests plugin:field:formatter generator.
 */
final class FormatterTest extends GeneratorTestBase {

  protected string $fixtureDir = __DIR__ . '/_formatter';

  public function testGenerator(): void {
    $input = [
      'foo',
      'Zoo',
      'foo_zoo',
      'ZooFormatter',
      'Yes',
    ];
    $this->execute(new Formatter(), $input);

    $expected_display = <<< 'TXT'

     Welcome to field-formatter generator!
    –––––––––––––––––––––––––––––––––––––––

     Module machine name [%default_name%]:
     ➤ 

     Plugin label [Example]:
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

    $this->assertGeneratedFile('config/schema/foo.schema.yml');
    $this->assertGeneratedFile('src/Plugin/Field/FieldFormatter/ZooFormatter.php');
  }

}
