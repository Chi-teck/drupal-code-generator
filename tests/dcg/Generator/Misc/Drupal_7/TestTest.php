<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Tests\Generator\Misc\Drupal_7;

use DrupalCodeGenerator\Tests\Generator\BaseGeneratorTest;

/**
 * Test for misc:d7:test-file command.
 */
final class TestTest extends BaseGeneratorTest {

  protected string $class = 'Misc\Drupal_7\Test';

  protected array $interaction = [
    'Module name [%default_name%]:' => 'Example',
    'Module machine name [example]:' => 'example',
    'Class [ExampleTestCase]:' => 'ExampleTestCase',
  ];

  protected array $fixtures = [
    'example.test' => '/_.test',
  ];

}
