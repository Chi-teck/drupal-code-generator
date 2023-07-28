<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Tests\Functional\Generator;

use DrupalCodeGenerator\Command\SingleDirectoryComponent;
use DrupalCodeGenerator\Test\Functional\GeneratorTestBase;

/**
 * Tests Single Directory Component generator.
 */
final class SingleDirectoryComponentTest extends GeneratorTestBase {

  protected string $fixtureDir = __DIR__ . '/_singledirectorycomponent';

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
    
     Welcome to singledirectorycomponent generator!
    ––––––––––––––––––––––––––––––––––––––––––––––––
    
     Theme name:
     ➤ 
    
     Theme machine name [foo]:
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
     • foo/components/bar/bar.component.yml
     • foo/components/bar/bar.twig
     • foo/components/bar/README.md
     • foo/components/bar/thumbnail.png

    TXT;
    $this->assertDisplay($expected_display);

    // $this->assertGeneratedFile('foo/foo.info.yml');
    // $this->assertGeneratedFile('foo/foo.install');
    // $this->assertGeneratedFile('foo/foo.module');
    // $this->assertGeneratedFile('foo/README.md');
  }
}
