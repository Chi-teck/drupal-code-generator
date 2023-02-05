<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Tests\Functional\Generator\Service;

use DrupalCodeGenerator\Command\Service\RequestPolicy;
use DrupalCodeGenerator\Test\Functional\GeneratorTestBase;

/**
 * Tests service:request-policy generator.
 */
final class RequestPolicyTest extends GeneratorTestBase {

  protected string $fixtureDir = __DIR__ . '/_request_policy';

  /**
   * Test callback.
   */
  public function testWithDependencies(): void {

    $input = [
      'example',
      'Foo',
      'Yes',
      'entity_type.manager',
      '',
    ];
    $this->execute(RequestPolicy::class, $input);

    $expected_display = <<< 'TXT'

     Welcome to request-policy generator!
    ––––––––––––––––––––––––––––––––––––––

     Module machine name:
     ➤ 

     Class [Example]:
     ➤ 

     Would you like to inject dependencies? [Yes]:
     ➤ 

     Type the service name or use arrows up/down. Press enter to continue:
     ➤ 

     Type the service name or use arrows up/down. Press enter to continue:
     ➤ 

     The following directories and files have been created or updated:
    –––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
     • example.info.yml
     • example.services.yml
     • src/PageCache/Foo.php

    TXT;
    $this->assertDisplay($expected_display);

    $this->assertGeneratedFile('example.services.yml', '_w_dep/example.services.yml');
    $this->assertGeneratedFile('src/PageCache/Foo.php', '_w_dep/src/PageCache/Foo.php');
  }

  /**
   * Test callback.
   */
  public function testWithoutDependencies(): void {

    $input = [
      'example',
      'MonteCarlo',
      'No',
    ];
    $this->execute(RequestPolicy::class, $input);

    $expected_display = <<< 'TXT'

     Welcome to request-policy generator!
    ––––––––––––––––––––––––––––––––––––––

     Module machine name:
     ➤ 

     Class [Example]:
     ➤ 

     Would you like to inject dependencies? [Yes]:
     ➤ 

     The following directories and files have been created or updated:
    –––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
     • example.info.yml
     • example.services.yml
     • src/PageCache/MonteCarlo.php

    TXT;
    $this->assertDisplay($expected_display);

    $this->assertGeneratedFile('example.services.yml', '_n_dep/example.services.yml');
    $this->assertGeneratedFile('src/PageCache/MonteCarlo.php', '_n_dep/src/PageCache/MonteCarlo.php');
  }

}
