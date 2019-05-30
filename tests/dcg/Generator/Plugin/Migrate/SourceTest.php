<?php

namespace DrupalCodeGenerator\Tests\Generator\Plugin\Migrate;

use DrupalCodeGenerator\Tests\Generator\BaseGeneratorTest;

/**
 * Test for plugin:migrate:source command.
 */
class SourceTest extends BaseGeneratorTest {

  protected $class = 'Plugin\Migrate\Source';

  /**
   * {@inheritdoc}
   */
  public function testGenerator() {

    $data_type_output = implode("\n", [
      'Source type:',
      '  [1] SQL',
      '  [2] Other',
    ]);

    // Source type 'SQL'.
    $interaction = [
      'Module name [%default_name%]:' => 'Example',
      'Module machine name [example]:' => 'example',
      'Plugin ID [example_example]:' => 'example_foo',
      'Plugin class [Foo]:' => 'Foo',
      $data_type_output => '2',
    ];
    $fixtures = [
      'src/Plugin/migrate/source/Foo.php' => '/_source_sql.php',
    ];
    parent::doTest($interaction, $fixtures);

    // Source type 'Other'.
    $interaction = [
      'Module name [%default_name%]:' => 'Example',
      'Module machine name [example]:' => 'example',
      'Plugin ID [example_example]:' => 'example_bar',
      'Plugin class [Bar]:' => 'Bar',
      $data_type_output => 2,
    ];
    $fixtures = [
      'src/Plugin/migrate/source/Bar.php' => '/_source_other.php',
    ];
    parent::doTest($interaction, $fixtures);
  }

}
