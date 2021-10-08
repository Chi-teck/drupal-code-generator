<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Tests\Generator\Misc\Drupal_7;

use DrupalCodeGenerator\Tests\Generator\BaseGeneratorTest;

/**
 * Test for misc:d7:javascript-file command.
 */
final class JavaScriptTest extends BaseGeneratorTest {

  protected $class = 'Misc\Drupal_7\JavaScript';

  protected $interaction = [
    'Module name [%default_name%]:' => 'Another example',
    'Module machine name [another_example]:' => 'another_example',
  ];

  protected $fixtures = [
    'another-example.js' => '/_javascript.js',
  ];

}
