<?php

namespace DrupalCodeGenerator\Tests\Generator;

/**
 * Test for service:middleware command.
 */
final class ServiceProviderTest extends BaseGeneratorTest {

  protected $class = 'ServiceProvider';

  protected $interaction = [
    'Module name [%default_name%]:' => 'Example',
    'Module machine name [example]:' => 'example',
  ];

  protected $fixtures = [
    'src/ExampleServiceProvider.php' => '/_service_provider.php',
  ];

}
