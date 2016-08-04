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
      'foo',
      'Example',
      'example',
      'Some description',
      'Custom',
      'Node',
    ];
    $this->target = 'plugins/content_types/example.inc';
    $this->fixture = __DIR__ . '/_content_type.inc';

    parent::setUp();
  }

}
