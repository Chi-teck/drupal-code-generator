<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Tests\Generator\Plugin\Views;

use DrupalCodeGenerator\Tests\Generator\BaseGeneratorTest;

/**
 * Test for plugin:views:argument-default command.
 */
final class ArgumentDefaultTest extends BaseGeneratorTest {

  protected string $class = 'Plugin\Views\ArgumentDefault';

  protected array $interaction = [
    'Module name [%default_name%]:' => 'Foo',
    'Module machine name [foo]:' => 'foo',
    'Plugin label [Example]:' => 'Example',
    'Plugin ID [foo_example]:' => 'foo_example',
    'Plugin class [Example]:' => 'Example',
    'Make the plugin configurable? [No]:' => 'Yes',
    'Would you like to inject dependencies? [No]:' => 'Yes',
    '<1> Type the service name or use arrows up/down. Press enter to continue:' => 'current_route_match',
    '<2> Type the service name or use arrows up/down. Press enter to continue:' => "\n",
  ];

  protected array $fixtures = [
    'config/schema/foo.views.schema.yml' => '/_argument_default_schema.yml',
    'src/Plugin/views/argument_default/Example.php' => '/_argument_default.php',
  ];

}
