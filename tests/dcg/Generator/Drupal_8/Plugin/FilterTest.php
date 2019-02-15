<?php

namespace DrupalCodeGenerator\Tests\Generator\Drupal_8\Plugin;

use DrupalCodeGenerator\Tests\Generator\GeneratorBaseTest;

/**
 * Test for d8:plugin:filter command.
 */
class FilterTest extends GeneratorBaseTest {

  protected $class = 'Drupal_8\Plugin\Filter';

  protected $fixtures = [
    'config/schema/foo.schema.yml' => __DIR__ . '/_filter_schema.yml',
    'src/Plugin/Filter/Example.php' => __DIR__ . '/_filter.php',
  ];

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    $filter_type_output = implode("\n", [
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
