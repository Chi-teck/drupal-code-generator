<?php

namespace DrupalCodeGenerator\Tests\Generator\Service;

use DrupalCodeGenerator\Tests\Generator\BaseGeneratorTest;

/**
 * Test for service:twig-extension command.
 */
final class TwigExtensionTest extends BaseGeneratorTest {

  protected $class = 'Service\TwigExtension';

  protected $interaction = [
    'Module name [%default_name%]:' => 'Example',
    'Module machine name [example]:' => 'example',
    'Class [ExampleTwigExtension]:' => 'ExampleTwigExtension',
    'Would you like to inject dependencies? [Yes]:' => 'Yes',
    '<1> Type the service name or use arrows up/down. Press enter to continue:' => 'entity_type.manager',
    '<2> Type the service name or use arrows up/down. Press enter to continue:' => "\n",
  ];

  protected $fixtures = [
    'example.services.yml' => '/_twig_extension.services.yml',
    'src/ExampleTwigExtension.php' => '/_twig_extension.php',
  ];

}
