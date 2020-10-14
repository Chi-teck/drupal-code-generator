<?php

namespace DrupalCodeGenerator\Tests\Generator;

use DrupalCodeGenerator\Command\JavaScript;
use DrupalCodeGenerator\Test\GeneratorTest;

/**
 * Test for javascript command.
 */
final class JavaScriptTest extends GeneratorTest {

  protected $fixtureDir = __DIR__;

  /**
   * Test callback.
   */
  public function testGenerator(): void {

    $this->execute(new JavaScript(), ['Foo bar', 'foo_bar']);

    $expected_display = <<< 'TXT'

     Welcome to javascript generator!
    ––––––––––––––––––––––––––––––––––

     Module name [%default_name%]:
     ➤ 

     Module machine name [foo_bar]:
     ➤ 

     The following directories and files have been created or updated:
    –––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
     • js/foo-bar.js


    TXT;
    $this->assertDisplay($expected_display);

    $this->assertGeneratedFile('js/foo-bar.js', '/_javascript.js');
  }

}
