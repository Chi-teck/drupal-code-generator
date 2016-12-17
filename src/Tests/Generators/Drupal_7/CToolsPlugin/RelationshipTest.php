<?php

namespace DrupalCodeGenerator\Tests\Drupal_7\CtoolsPlugin;

use DrupalCodeGenerator\Tests\GeneratorTestCase;

/**
 * Test for d7:ctools-plugin:relationship command.
 */
class RelationshipTest extends GeneratorTestCase {

  protected $class = 'Drupal_7\CToolsPlugin\Relationship';
  protected $answers = [
    'Foo',
    'foo',
    'Example',
    'example',
    'Some description',
    'custom',
    'Term',
  ];
  protected $fixtures = [
    'plugins/relationships/example.inc' => __DIR__ . '/_relationship.inc',
  ];

}
