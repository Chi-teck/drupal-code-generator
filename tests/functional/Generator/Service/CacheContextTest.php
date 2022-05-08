<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Tests\Generator\Service;

use DrupalCodeGenerator\Command\Service\CacheContext;
use DrupalCodeGenerator\Test\Functional\GeneratorTestBase;

/**
 * Tests service:cache-context generator.
 */
final class CacheContextTest extends GeneratorTestBase {

  protected string $fixtureDir = __DIR__ . '/_cache_context';

  public function testCalculatedCacheContext(): void {
    $input = [
      'foo',
      'example',
      'ExampleCacheContext',
      'RequestStackCacheContextBase',
      'Yes',
    ];
    $this->execute(new CacheContext(), $input);

    $expected_display = <<< 'TXT'

     Welcome to cache-context generator!
    –––––––––––––––––––––––––––––––––––––

     Module machine name [%default_name%]:
     ➤ 

     Context ID [example]:
     ➤ 

     Class [ExampleCacheContext]:
     ➤ 

     Base class:
      [0] -
      [1] RequestStackCacheContextBase
      [2] UserCacheContextBase
     ➤ 

     Make the context calculated? [No]:
     ➤ 

     The following directories and files have been created or updated:
    –––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
     • foo.services.yml
     • src/Cache/Context/ExampleCacheContext.php

    TXT;
    $this->assertDisplay($expected_display);

    $this->fixtureDir .= '/_calculated';
    $this->assertGeneratedFile('foo.services.yml');
    $this->assertGeneratedFile('src/Cache/Context/ExampleCacheContext.php');
  }

  public function testNotCalculatedCacheContext(): void {
    $input = [
      'foo',
      'example',
      'ExampleCacheContext',
      'RequestStackCacheContextBase',
      'Not',
    ];
    $this->execute(new CacheContext(), $input);

    $expected_display = <<< 'TXT'

     Welcome to cache-context generator!
    –––––––––––––––––––––––––––––––––––––

     Module machine name [%default_name%]:
     ➤ 

     Context ID [example]:
     ➤ 

     Class [ExampleCacheContext]:
     ➤ 

     Base class:
      [0] -
      [1] RequestStackCacheContextBase
      [2] UserCacheContextBase
     ➤ 

     Make the context calculated? [No]:
     ➤ 

     The following directories and files have been created or updated:
    –––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
     • foo.services.yml
     • src/Cache/Context/ExampleCacheContext.php

    TXT;
    $this->assertDisplay($expected_display);

    $this->fixtureDir .= '/_not_calculated';
    $this->assertGeneratedFile('foo.services.yml');
    $this->assertGeneratedFile('src/Cache/Context/ExampleCacheContext.php');
  }

}
