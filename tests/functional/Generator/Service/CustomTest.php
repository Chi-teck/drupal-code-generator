<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Tests\Generator\Service;

use DrupalCodeGenerator\Command\Service\Custom;
use DrupalCodeGenerator\Test\Functional\GeneratorTestBase;

/**
 * Tests service:custom generator.
 */
final class CustomTest extends GeneratorTestBase {

  protected string $fixtureDir = __DIR__ . '/_custom';

  /**
   * Test callback.
   */
  public function testWithDependencies(): void {
    $input = [
      'foo',
      'foo.example',
      'Example',
      'No',
      'Yes',
      'entity_type.manager',
      'cron',
      'cache_tags.invalidator',
      '',
    ];
    $this->execute(Custom::class, $input);

    $expected_display = <<< 'TXT'

     Welcome to custom-service generator!
    ––––––––––––––––––––––––––––––––––––––

     Module machine name:
     ➤ 

     Service name [foo.example]:
     ➤ 

     Class [Example]:
     ➤ 

     Would like to create an interface for this class? [No]:
     ➤ 

     Would you like to inject dependencies? [Yes]:
     ➤ 

     Type the service name or use arrows up/down. Press enter to continue:
     ➤ 

     Type the service name or use arrows up/down. Press enter to continue:
     ➤ 

     Type the service name or use arrows up/down. Press enter to continue:
     ➤ 

     Type the service name or use arrows up/down. Press enter to continue:
     ➤ 

     The following directories and files have been created or updated:
    –––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
     • foo.info.yml
     • foo.services.yml
     • src/Example.php

    TXT;
    $this->assertDisplay($expected_display);

    $this->assertGeneratedFile('foo.services.yml', '_w_deps/foo.services.yml');
    $this->assertGeneratedFile('src/Example.php', '_w_deps/src/Example.php');
  }

  /**
   * Test callback.
   */
  public function testWithoutDependencies(): void {
    $input = [
      'foo',
      'foo.example',
      'Example',
      'No',
      'No',
    ];
    $this->execute(Custom::class, $input);

    $expected_display = <<< 'TXT'

     Welcome to custom-service generator!
    ––––––––––––––––––––––––––––––––––––––

     Module machine name:
     ➤ 

     Service name [foo.example]:
     ➤ 

     Class [Example]:
     ➤ 

     Would like to create an interface for this class? [No]:
     ➤ 

     Would you like to inject dependencies? [Yes]:
     ➤ 

     The following directories and files have been created or updated:
    –––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
     • foo.info.yml
     • foo.services.yml
     • src/Example.php

    TXT;
    $this->assertDisplay($expected_display);

    $this->assertGeneratedFile('foo.services.yml', '_n_deps/foo.services.yml');
    $this->assertGeneratedFile('src/Example.php', '_n_deps/src/Example.php');
  }

  /**
   * Test callback.
   */
  public function testWithInterface(): void {
    $input = [
      'foo',
      'foo.bar',
      'SuperBar',
      'Yes',
      'No',
    ];
    $this->execute(Custom::class, $input);

    $expected_display = <<< 'TXT'

     Welcome to custom-service generator!
    ––––––––––––––––––––––––––––––––––––––

     Module machine name:
     ➤ 

     Service name [foo.example]:
     ➤ 

     Class [Bar]:
     ➤ 

     Would like to create an interface for this class? [No]:
     ➤ 

     Would you like to inject dependencies? [Yes]:
     ➤ 

     The following directories and files have been created or updated:
    –––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
     • foo.info.yml
     • foo.services.yml
     • src/SuperBar.php
     • src/SuperBarInterface.php

    TXT;
    $this->assertDisplay($expected_display);

    $this->assertGeneratedFile('foo.services.yml', '_w_interface/foo.services.yml');
    $this->assertGeneratedFile('src/SuperBar.php', '_w_interface/src/SuperBar.php');
    $this->assertGeneratedFile('src/SuperBarInterface.php', '_w_interface/src/SuperBarInterface.php');
  }

}
