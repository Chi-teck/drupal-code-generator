<?php

namespace DrupalCodeGenerator\Tests\Drupal_7\ViewsPlugin;

use DrupalCodeGenerator\Tests\GeneratorTestCase;

/**
 * Test for d7:views-plugin:argument-default command.
 */
class ArgumentDefaultTest extends GeneratorTestCase {

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    $this->class = 'Drupal_7\ViewsPlugin\ArgumentDefault';
    $this->answers = [
      'Example',
      'example',
      'Foo',
      'foo',
    ];
    $this->target = 'views_plugin_argument_foo.inc';
    $this->fixture = __DIR__ . '/_argument_default.inc';
    parent::setUp();
  }

}
