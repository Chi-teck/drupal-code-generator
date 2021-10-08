<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Tests\Generator\Plugin;

use DrupalCodeGenerator\Tests\Generator\BaseGeneratorTest;

/**
 * Test for plugin:filter command.
 */
final class FilterTest extends BaseGeneratorTest {

  protected string $class = 'Plugin\Filter';

  protected array $fixtures = [
    'config/schema/foo.schema.yml' => '/_filter_schema.yml',
    'src/Plugin/Filter/Example.php' => '/_filter.php',
  ];

  /**
   * {@inheritdoc}
   */
  public function setUp(): void {
    $filter_type_output = \implode("\n", [
      'Filter type:',
      '  [1] HTML restrictor',
      '  [2] Markup language',
      '  [3] Irreversible transformation',
      '  [4] Reversible transformation',
    ]);
    $this->interaction = [
      'Module name [%default_name%]:' => 'Foo',
      'Module machine name [foo]:' => 'foo',
      'Plugin label [Example]:' => 'Example',
      'Plugin ID [foo_example]:' => 'foo_example',
      'Plugin class [Example]:' => 'Example',
      $filter_type_output => '1',
    ];
    parent::setUp();
  }

}
