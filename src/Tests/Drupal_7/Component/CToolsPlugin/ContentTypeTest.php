<?php

// @TODO: Create CtoolsPlugin name space.
namespace DrupalCodeGenerator\Tests\Drupal_7\Component;

use DrupalCodeGenerator\Tests\GeneratorTestCase;
use DrupalCodeGenerator\Commands\Drupal_7\Component\CToolsPlugin\ContentType;

class CtoolsPluginContentTypeTest extends GeneratorTestCase {

  /**
   * {@inheritdoc}
   */
  public function setUp () {
    $this->command = new ContentType();
    $this->commandName = 'generate:d7:component:ctools-plugin:content-type';
    $this->answers = [
      'Node title',
      'node_title',
      'Some description',
      'custom',
    ];
    $this->target = 'node_title.inc';
    $this->fixture = __DIR__ . '/_' . $this->target;

    parent::setUp();
  }

}
