<?php

namespace DrupalCodeGenerator\Tests\Drupal_7\Component;

use DrupalCodeGenerator\Tests\GeneratorTestCase;
use DrupalCodeGenerator\Commands\Drupal_7\Component\CToolsPlugin\Relationship;

class CtoolsPluginRelationshipTest extends GeneratorTestCase {

  /**
   * {@inheritdoc}
   */
  public function setUp () {
    $this->command = new Relationship();
    $this->commandName = 'generate:d7:component:ctools-plugin:relationship';
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
