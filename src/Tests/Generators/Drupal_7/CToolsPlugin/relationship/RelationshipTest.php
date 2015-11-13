<?php

namespace DrupalCodeGenerator\Tests\Drupal_7;

use DrupalCodeGenerator\Tests\GeneratorTestCase;

/**
 * Test for d7:ctools-plugin:relationship command.
 */
class CtoolsPluginRelationshipTest extends GeneratorTestCase {

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    $this->class = 'Drupal_7\CToolsPlugin\Relationship';
    $this->answers = [
      'Example',
      'example',
      'Some description',
      'custom',
      'Term',
    ];
    $this->target = 'example.inc';
    $this->fixture = __DIR__ . '/_' . $this->target;

    parent::setUp();
  }

}
