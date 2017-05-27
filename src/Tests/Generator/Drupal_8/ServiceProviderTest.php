<?php

namespace DrupalCodeGenerator\Tests\Generator\Drupal_8;

use DrupalCodeGenerator\Tests\Generator\GeneratorTestCase;

/**
 * Test for d8:service:middleware command.
 */
class ServiceProviderTest extends GeneratorTestCase {

  protected $class = 'Drupal_8\ServiceProvider';

  protected $answers = [
    'Example',
    'example',
  ];

  protected $fixtures = [
    'src/ExampleServiceProvider.php' => __DIR__ . '/_service_provider.php',
  ];

}
