<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Tests\Generator\Form;

use DrupalCodeGenerator\Tests\Generator\BaseGeneratorTest;

/**
 * Test for form:simple command.
 */
final class SimpleTest extends BaseGeneratorTest {

  protected string $class = 'Form\Simple';

  protected array $interaction = [
    'Module name [%default_name%]:' => 'Foo',
    'Module machine name [foo]:' => 'foo',
    'Class [ExampleForm]:' => 'ExampleForm',
    'Would you like to create a route for this form? [Yes]:' => 'Yes',
    'Route name [foo.example]:' => 'foo.example',
    'Route path [/foo/example]:' => '/foo/example',
    'Route title [Example]:' => 'Hey',
    'Route permission [access content]:' => 'access content',
  ];

  protected array $fixtures = [
    'foo.routing.yml' => '/_simple_routing.yml',
    'src/Form/ExampleForm.php' => '/_simple.php',
  ];

}
