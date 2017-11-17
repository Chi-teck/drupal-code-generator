<?php

namespace DrupalCodeGenerator\Tests\Generator\Drupal_8\Plugin\Migrate;

use DrupalCodeGenerator\Tests\Generator\GeneratorBaseTest;

/**
 * Test for d8:plugin:migrate:process command.
 */
class ProcessTest extends GeneratorBaseTest {

  protected $class = 'Drupal_8\Plugin\Migrate\Process';

  protected $interaction = [
    'Module name [%default_name%]:' => 'Example',
    'Module machine name [example]:' => 'example',
    'Plugin ID [example_example]:' => 'example_qux',
  ];

  protected $fixtures = [
    'src/Plugin/migrate/process/Qux.php' => __DIR__ . '/_process.php',
  ];

}
