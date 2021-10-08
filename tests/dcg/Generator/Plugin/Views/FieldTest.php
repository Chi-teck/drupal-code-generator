<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Tests\Generator\Plugin\Views;

use DrupalCodeGenerator\Tests\Generator\BaseGeneratorTest;

/**
 * Test for plugin:views:field command.
 */
final class FieldTest extends BaseGeneratorTest {

  protected string $class = 'Plugin\Views\Field';

  protected array $interaction = [
    'Module name [%default_name%]:' => 'Foo',
    'Module machine name [foo]:' => 'foo',
    'Plugin label [Example]:' => 'Example',
    'Plugin ID [foo_example]:' => 'foo_example',
    'Plugin class [Example]:' => 'Example',
    'Make the plugin configurable? [No]:' => 'Yes',
    'Would you like to inject dependencies? [No]:' => 'Yes',
    '<1> Type the service name or use arrows up/down. Press enter to continue:' => 'entity_type.manager',
    '<2> Type the service name or use arrows up/down. Press enter to continue:' => "\n",
  ];

  protected array $fixtures = [
    'config/schema/foo.views.schema.yml' => '/_field_schema.yml',
    'src/Plugin/views/field/Example.php' => '/_field.php',
  ];

}
