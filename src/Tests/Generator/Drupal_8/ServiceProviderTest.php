<?php

namespace DrupalCodeGenerator\Tests\Generator\Drupal_8;

use DrupalCodeGenerator\Tests\Generator\GeneratorBaseTest;

/**
 * Test for d8:service:middleware command.
 */
class ServiceProviderTest extends GeneratorBaseTest {

  protected $class = 'Drupal_8\ServiceProvider';

  protected $interaction = [
    'Module name [%default_name%]: ' => 'Example',
    'Module machine name [example]: ' => 'example',
  ];

  protected $fixtures = [
    'src/ExampleServiceProvider.php' => __DIR__ . '/_service_provider.php',
  ];

}
