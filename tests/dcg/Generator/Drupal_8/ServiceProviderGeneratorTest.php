<?php

namespace DrupalCodeGenerator\Tests\Generator\Drupal_8;

use DrupalCodeGenerator\Tests\Generator\BaseGeneratorTest;

/**
 * Test for service:middleware command.
 */
class ServiceProviderGeneratorTest extends BaseGeneratorTest {

  protected $class = 'ServiceProvider';

  protected $interaction = [
    'Module name [%default_name%]:' => 'Example',
    'Module machine name [example]:' => 'example',
  ];

  protected $fixtures = [
    'src/ExampleServiceProvider.php' => __DIR__ . '/_service_provider.php',
  ];

}
