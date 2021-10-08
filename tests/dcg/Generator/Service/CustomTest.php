<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Tests\Generator\Service;

use DrupalCodeGenerator\Tests\Generator\BaseGeneratorTest;

/**
 * Test for service:custom command.
 */
final class CustomTest extends BaseGeneratorTest {

  protected string $class = 'Service\Custom';

  protected array $interaction = [
    'Module name [%default_name%]:' => 'Foo',
    'Module machine name [foo]:' => 'foo',
    'Service name [foo.example]:' => 'foo.example',
    'Class [Example]:' => 'Example',
    'Would you like to inject dependencies? [Yes]:' => 'Yes',
    '<1> Type the service name or use arrows up/down. Press enter to continue:' => 'entity_type.manager',
    '<2> Type the service name or use arrows up/down. Press enter to continue:' => 'cron',
    '<3> Type the service name or use arrows up/down. Press enter to continue:' => 'cache_tags.invalidator',
    '<4> Type the service name or use arrows up/down. Press enter to continue:' => "\n",
  ];

  protected array $fixtures = [
    'foo.services.yml' => '/_custom.services.yml',
    'src/Example.php' => '/_custom.php',
  ];

}
