<?php

namespace DrupalCodeGenerator\Tests\Generator\Drupal_8\Plugin\Migrate;

use DrupalCodeGenerator\Tests\Generator\GeneratorBaseTest;

/**
 * Test for d8:plugin:migrate:destination command.
 */
class DestinationTest extends GeneratorBaseTest {

  protected $class = 'Drupal_8\Plugin\Migrate\Destination';

  protected $interaction = [
    'Module name [%default_name%]:' => 'Example',
    'Module machine name [example]:' => 'example',
    'Plugin ID [example_example]:' => 'example_bar',
    'Plugin class [Bar]:' => 'Bar',
  ];

  protected $fixtures = [
    'src/Plugin/migrate/destination/Bar.php' => __DIR__ . '/_destination.php',
  ];

}
