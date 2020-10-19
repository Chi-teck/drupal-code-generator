<?php

namespace DrupalCodeGenerator\Tests\Generator;

use DrupalCodeGenerator\Command\ThemeFile;
use DrupalCodeGenerator\Test\GeneratorTest;

/**
 * Test for theme-file command.
 */
final class ThemeFileTest extends GeneratorTest {

  protected $fixtureDir = __DIR__;

  /**
   * Test callback.
   */
  public function testGenerator(): void {

    $this->execute(new ThemeFile(), ['Foo', 'foo']);

    $expected_display = <<< 'TXT'

     Welcome to theme-file generator!
    ––––––––––––––––––––––––––––––––––

     Theme name [%default_name%]:
     ➤ 

     Theme machine name [foo]:
     ➤ 

     The following directories and files have been created or updated:
    –––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
     • foo.theme


    TXT;
    $this->assertDisplay($expected_display);

    $this->assertGeneratedFile('foo.theme', '_.theme');
  }

}
