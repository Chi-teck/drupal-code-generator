<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Tests\Functional\Generator;

use DrupalCodeGenerator\Command\SingleDirectoryComponent;
use DrupalCodeGenerator\Test\Functional\GeneratorTestBase;

/**
 * Tests Single Directory Component generator.
 */
final class SingleDirectoryComponentTest extends GeneratorTestBase {

  protected string $fixtureDir = __DIR__ . '/_sdc';

  /**
   * Test callback.
   */
  public function testGenerator(): void {

    $input = [
      'foo',
      '',
      '',
      'foo',
      'bar',
      'bar',
      '1',
      '',
      'no',
      'no',
      'no',
    ];
    $this->execute(SingleDirectoryComponent::class, $input);

    $expected_display = <<< 'TXT'
    
     Welcome to sdc generator!
    –––––––––––––––––––––––––––
    
     Theme machine name:
     ➤ 
    
     Theme name [Foo]:
     ➤ 
    
     Components directory [components]:
     ➤ 
    
     Component name:
     ➤ 
    
     Component machine name [foo]:
     ➤ 
    
     Component description (optional):
     ➤ 
    
     Project type [stable]:
      [1] stable
      [2] experimental
      [3] deprecated
      [4] obsolete
     ➤ 
    
     Library dependencies (optional). [Example: core/once]:
     ➤ 
    
     Needs CSS? [Yes]:
     ➤ 
    
     Needs JS? [Yes]:
     ➤ 
    
     Needs component props? [Yes]:
     ➤ 
    
     The following directories and files have been created or updated:
    –––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
     • components/bar/bar.component.yml
     • components/bar/bar.twig
     • components/bar/README.md
     • components/bar/thumbnail.jpg

    TXT;
    $this->assertDisplay($expected_display);

    $this->assertGeneratedFile('components/bar/bar.component.yml');
    $this->assertGeneratedFile('components/bar/bar.twig');
    $this->assertGeneratedFile('components/bar/README.md');
    $this->assertGeneratedFile('components/bar/thumbnail.jpg');
  }

}
