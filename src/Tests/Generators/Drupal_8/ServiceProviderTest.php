<?php

namespace DrupalCodeGenerator\Tests\Drupal_8;

use DrupalCodeGenerator\Tests\GeneratorTestCase;

/**
 * Test for d8:service:middleware command.
 */
class ServiceProviderTest extends GeneratorTestCase {

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    $this->class = 'Drupal_8\ServiceProvider';
    $this->answers = [
      'Example',
      'example',
    ];
    $this->target = 'ExampleServiceProvider.php';
    $this->fixture = __DIR__ . '/_service_provider.php';

    parent::setUp();
  }

}
