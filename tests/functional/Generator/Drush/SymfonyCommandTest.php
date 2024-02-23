<?php

declare(strict_types=1);

namespace DrupalCodeGenerator\Tests\Functional\Drush;

use DrupalCodeGenerator\Command\Drush\SymfonyCommand;
use DrupalCodeGenerator\Test\Functional\GeneratorTestBase;

/**
 * Tests drush:symfony-command generator.
 */
final class SymfonyCommandTest extends GeneratorTestBase {

  protected string $fixtureDir = __DIR__ . '/_symfony_command';

  /**
   * Test callback.
   */
  public function testWithDependencies(): void {

    $input = [
      'foo',
      'Foo',
      'foo:bar',
      'Example command.',
      'bar',
      'BarCommand',
      'Yes',
      'Yes',
      'entity_type.manager',
      '',
    ];
    $this->execute(SymfonyCommand::class, $input);

    $expected_display = <<< 'TXT'

     Welcome to symfony-command generator!
    –––––––––––––––––––––––––––––––––––––––

     Module machine name:
     ➤ 

     Module name [Foo]:
     ➤ 

     Command name [foo:example]:
     ➤ 

     Command description:
     ➤ 

     Command alias [bar]:
     ➤ 

     Class [BarCommand]:
     ➤ 

     Would you like to run the command with Drush [Yes]:
     ➤ 

     Would you like to inject dependencies? [No]:
     ➤ 

     Type the service name or use arrows up/down. Press enter to continue:
     ➤ 

     Type the service name or use arrows up/down. Press enter to continue:
     ➤ 

     The following directories and files have been created or updated:
    –––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
     • drush.services.yml
     • foo.info.yml
     • src/Command/BarCommand.php

    TXT;
    $this->assertDisplay($expected_display);

    $this->fixtureDir .= '/_w_deps';
    $this->assertGeneratedFile('drush.services.yml');
    $this->assertGeneratedFile('src/Command/BarCommand.php');
  }

  /**
   * Test callback.
   */
  public function testWithoutDependencies(): void {

    $input = [
      'foo',
      'Foo',
      'bar',
      'Bar command.',
      'bar',
      'BarCommand',
      'Yes',
      'No',
    ];
    $this->execute(SymfonyCommand::class, $input);

    $expected_display = <<< 'TXT'

     Welcome to symfony-command generator!
    –––––––––––––––––––––––––––––––––––––––

     Module machine name:
     ➤ 

     Module name [Foo]:
     ➤ 

     Command name [foo:example]:
     ➤ 

     Command description:
     ➤ 

     Command alias [bar]:
     ➤ 

     Class [BarCommand]:
     ➤ 

     Would you like to run the command with Drush [Yes]:
     ➤ 

     Would you like to inject dependencies? [No]:
     ➤ 

     The following directories and files have been created or updated:
    –––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
     • drush.services.yml
     • foo.info.yml
     • src/Command/BarCommand.php

    TXT;
    $this->assertDisplay($expected_display);

    $this->fixtureDir .= '/_n_deps';
    $this->assertGeneratedFile('drush.services.yml');
    $this->assertGeneratedFile('src/Command/BarCommand.php');
  }

}
