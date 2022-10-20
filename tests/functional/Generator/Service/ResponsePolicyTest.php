<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Tests\Functional\Generator\Service;

use DrupalCodeGenerator\Command\Service\ResponsePolicy;
use DrupalCodeGenerator\Test\Functional\GeneratorTestBase;

/**
 * Tests service:response-policy generator.
 */
final class ResponsePolicyTest extends GeneratorTestBase {

  protected string $fixtureDir = __DIR__ . '/_response_policy';

  /**
   * Test callback.
   */
  public function testWithDependencies(): void {

    $input = [
      'foo',
      'Example',
      'Yes',
      'entity_type.manager',
      '',
    ];
    $this->execute(ResponsePolicy::class, $input);

    $expected_display = <<< 'TXT'

     Welcome to response-policy generator!
    –––––––––––––––––––––––––––––––––––––––

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
     • foo.services.yml
     • src/PageCache/Example.php

    TXT;
    $this->assertDisplay($expected_display);

    $this->assertGeneratedFile('foo.services.yml', '_w_dep/foo.services.yml');
    $this->assertGeneratedFile('src/PageCache/Example.php', '_w_dep/src/PageCache/Example.php');
  }

  /**
   * Test callback.
   */
  public function testWithoutDependencies(): void {

    $this->execute(ResponsePolicy::class, ['foo', 'Example', 'No']);

    $expected_display = <<< 'TXT'

     Welcome to response-policy generator!
    –––––––––––––––––––––––––––––––––––––––

     Module machine name:
     ➤ 

     Class [Example]:
     ➤ 

     Would you like to inject dependencies? [Yes]:
     ➤ 

     The following directories and files have been created or updated:
    –––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
     • foo.services.yml
     • src/PageCache/Example.php

    TXT;
    $this->assertDisplay($expected_display);

    $this->assertGeneratedFile('foo.services.yml', '_n_dep/foo.services.yml');
    $this->assertGeneratedFile('src/PageCache/Example.php', '_n_dep/src/PageCache/Example.php');
  }

}
