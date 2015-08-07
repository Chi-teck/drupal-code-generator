<?php

namespace DrupalCodeGenerator\Tests\Drupal_7\Component;

use DrupalCodeGenerator\Tests\GeneratorTestCase;

class CtoolsPluginRelationshipTest extends GeneratorTestCase {

  /**
   * {@inheritdoc}
   */
  public function setUp () {
    $this->class = 'Drupal_7\Component\CToolsPlugin\Relationship';
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
