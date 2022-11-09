<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Tests\Generator\Service;

use DrupalCodeGenerator\Command\Service\AccessChecker;
use DrupalCodeGenerator\Test\Functional\GeneratorTestBase;

/**
 * Tests service:access-checker generator.
 */
final class AccessCheckerTest extends GeneratorTestBase {

  protected string $fixtureDir = __DIR__ . '/_access_checker';

  /**
   * Test callback.
   */
  public function testWithoutDependencies(): void {

    $input = [
      'example',
      '_foo',
      'FooAccessChecker',
      'No',
    ];
    $this->execute(AccessChecker::class, $input);

    $expected_display = <<< 'TXT'

     Welcome to access-checker generator!
    ––––––––––––––––––––––––––––––––––––––

     Module machine name:
     ➤ 

     Requirement [_foo]:
     ➤ 

     Class [FooAccessChecker]:
     ➤ 

     Would you like to inject dependencies? [No]:
     ➤ 

     The following directories and files have been created or updated:
    –––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
     • example.services.yml
     • src/Access/FooAccessChecker.php

    TXT;
    $this->assertDisplay($expected_display);

    $this->assertGeneratedFile('example.services.yml', '_n_deps/example.services.yml');
    $this->assertGeneratedFile('src/Access/FooAccessChecker.php', '_n_deps/src/Access/FooAccessChecker.php');
  }

  /**
   * Test callback.
   */
  public function testWithDependencies(): void {

    $input = [
      'example',
      '_foo',
      'FooAccessChecker',
      'Yes',
      'cron',
      '',
    ];
    $this->execute(AccessChecker::class, $input);

    $expected_display = <<< 'TXT'

     Welcome to access-checker generator!
    ––––––––––––––––––––––––––––––––––––––

     Module machine name:
     ➤ 

     Requirement [_foo]:
     ➤ 

     Class [FooAccessChecker]:
     ➤ 

     Would you like to inject dependencies? [No]:
     ➤ 

     Type the service name or use arrows up/down. Press enter to continue:
     ➤ 

     Type the service name or use arrows up/down. Press enter to continue:
     ➤ 

     The following directories and files have been created or updated:
    –––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
     • example.services.yml
     • src/Access/FooAccessChecker.php

    TXT;
    $this->assertDisplay($expected_display);

    $this->assertGeneratedFile('example.services.yml', '_w_deps/example.services.yml');
    $this->assertGeneratedFile('src/Access/FooAccessChecker.php', '_w_deps/src/Access/FooAccessChecker.php');
  }

  /**
   * Test callback.
   */
  public function testRequirementValidation(): void {

    $input = [
      'example',
      'wrong_requirement',
      '_foo',
      'FooAccessChecker',
      'No',
    ];
    $this->execute(AccessChecker::class, $input);

    $expected_display = <<< 'TXT'

     Welcome to access-checker generator!
    ––––––––––––––––––––––––––––––––––––––

     Module machine name:
     ➤ 

     Requirement [_foo]:
     ➤  The value is not correct name for requirement name.

     Requirement [_foo]:
     ➤ 

     Class [FooAccessChecker]:
     ➤ 

     Would you like to inject dependencies? [No]:
     ➤ 

     The following directories and files have been created or updated:
    –––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
     • example.services.yml
     • src/Access/FooAccessChecker.php

    TXT;
    $this->assertDisplay($expected_display);

  }

}
