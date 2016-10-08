<?php

namespace DrupalCodeGenerator\Tests\Drupal_8\Plugin;

use DrupalCodeGenerator\Tests\GeneratorTestCase;

/**
 * Test for d8:plugin:rest-resource command.
 */
class RestResourceTest extends GeneratorTestCase {

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    $this->class = 'Drupal_8\Plugin\RestResource';
    $this->answers = [
      'Example',
      'example',
      'Foo',
      'example_foo',
    ];
    $this->target = 'FooResource.php';
    $this->fixture = __DIR__ . '/_rest_resource.php';

    parent::setUp();
  }

}
