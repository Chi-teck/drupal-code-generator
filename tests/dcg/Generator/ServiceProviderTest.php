<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Tests\Generator;

/**
 * Test for service:middleware command.
 */
final class ServiceProviderTest extends BaseGeneratorTest {

  protected string $class = 'ServiceProvider';

  protected array $interaction = [
    'Module name [%default_name%]:' => 'Example',
    'Module machine name [example]:' => 'example',
  ];

  protected array $fixtures = [
    'src/ExampleServiceProvider.php' => '/_service_provider.php',
  ];

}
