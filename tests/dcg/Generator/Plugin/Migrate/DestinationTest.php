<?php

namespace DrupalCodeGenerator\Tests\Generator\Plugin\Migrate;

use DrupalCodeGenerator\Tests\Generator\BaseGeneratorTest;

/**
 * Test for plugin:migrate:destination command.
 */
class DestinationTest extends BaseGeneratorTest {

  protected $class = 'Plugin\Migrate\Destination';

  protected $interaction = [
    'Module name [%default_name%]:' => 'Example',
    'Module machine name [example]:' => 'example',
    'Plugin ID [example_example]:' => 'example_bar',
    'Plugin class [Bar]:' => 'Bar',
  ];

  protected $fixtures = [
    'src/Plugin/migrate/destination/Bar.php' => '/_destination.php',
  ];

}
