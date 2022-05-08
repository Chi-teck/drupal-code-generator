<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Tests\Generator\Service;

use DrupalCodeGenerator\Command\Service\AccessChecker;
use DrupalCodeGenerator\Test\Functional\GeneratorTestBase;

/**
 * Tests service:access-checker generator.
 */
final class AccessCheckerTest extends GeneratorTestBase {

  protected string $fixtureDir = __DIR__ . '/_access_checker';

  public function testGenerator(): void {
    $input = [
      'example',
      '_foo',
      'FooAccessChecker',
    ];
    $this->execute(new AccessChecker(), $input);

    $expected_display = <<< 'TXT'

     Welcome to access-checker generator!
    ––––––––––––––––––––––––––––––––––––––

     Module machine name [%default_name%]:
     ➤ 

     Applies to [_foo]:
     ➤ 

     Class [FooAccessChecker]:
     ➤ 

     The following directories and files have been created or updated:
    –––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
     • example.services.yml
     • src/Access/FooAccessChecker.php

    TXT;
    $this->assertDisplay($expected_display);

    $this->assertGeneratedFile('example.services.yml');
    $this->assertGeneratedFile('src/Access/FooAccessChecker.php');
  }

}
