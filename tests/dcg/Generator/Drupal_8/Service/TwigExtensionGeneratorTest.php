<?php

namespace DrupalCodeGenerator\Tests\Generator\Drupal_8\Service;

use DrupalCodeGenerator\Tests\Generator\BaseGeneratorTest;

/**
 * Test for d8:service:twig-extension command.
 */
class TwigExtensionGeneratorTest extends BaseGeneratorTest {

  protected $class = 'Drupal_8\Service\TwigExtension';

  protected $interaction = [
    'Module name [%default_name%]:' => 'Example',
    'Module machine name [example]:' => 'example',
    'Class [ExampleTwigExtension]:' => 'ExampleTwigExtension',
    'Would you like to inject dependencies? [Yes]:' => 'Yes',
    '<1> Type the service name or use arrows up/down. Press enter to continue:' => 'entity_type.manager',
    '<2> Type the service name or use arrows up/down. Press enter to continue:' => "\n",
  ];

  protected $fixtures = [
    'example.services.yml' => __DIR__ . '/_twig_extension.services.yml',
    'src/ExampleTwigExtension.php' => __DIR__ . '/_twig_extension.php',
  ];

}
