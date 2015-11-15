<?php

namespace DrupalCodeGenerator\Tests\Drupal_7\CtoolsPlugin;

use DrupalCodeGenerator\Tests\GeneratorTestCase;

/**
 * Test for d7:ctools-plugin:content-type command.
 */
class ContentTypeTest extends GeneratorTestCase {

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    $this->class = 'Drupal_7\CToolsPlugin\ContentType';
    $this->answers = [
      'Example',
      'example',
      'Some description',
      'custom',
      'Node',
    ];
    $this->target = 'example.inc';
    $this->fixture = __DIR__ . '/_content_type.inc';

    parent::setUp();
  }

}
