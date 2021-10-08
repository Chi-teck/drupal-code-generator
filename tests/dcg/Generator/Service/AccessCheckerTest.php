<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Tests\Generator\Service;

use DrupalCodeGenerator\Tests\Generator\BaseGeneratorTest;

/**
 * Test for service:access-checker command.
 */
final class AccessCheckerTest extends BaseGeneratorTest {

  protected string $class = 'Service\AccessChecker';

  protected array $interaction = [
    'Module name [%default_name%]:' => 'Example',
    'Module machine name [example]:' => 'example',
    'Applies to [_foo]:' => '_foo',
    'Class [FooAccessChecker]:' => 'FooAccessChecker',
  ];

  protected array $fixtures = [
    'example.services.yml' => '/_access_checker.services.yml',
    'src/Access/FooAccessChecker.php' => '/_access_checker.php',
  ];

}
