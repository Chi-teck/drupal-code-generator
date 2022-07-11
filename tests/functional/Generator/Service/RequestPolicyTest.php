<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Tests\Functional\Generator\Service;

use DrupalCodeGenerator\Command\Service\RequestPolicy;
use DrupalCodeGenerator\Test\Functional\GeneratorTestBase;

/**
 * Tests service:request-policy generator.
 */
final class RequestPolicyTest extends GeneratorTestBase {

  protected string $fixtureDir = __DIR__ . '/_request_policy';

  public function testGenerator(): void {

    $this->execute(RequestPolicy::class, ['foo', 'Example']);

    $expected_display = <<< 'TXT'

     Welcome to request-policy generator!
    ––––––––––––––––––––––––––––––––––––––

     Module machine name:
     ➤ 

     Class [Example]:
     ➤ 

     The following directories and files have been created or updated:
    –––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
     • foo.services.yml
     • src/PageCache/Example.php

    TXT;
    $this->assertDisplay($expected_display);

    $this->assertGeneratedFile('foo.services.yml');
    $this->assertGeneratedFile('src/PageCache/Example.php');
  }

}
