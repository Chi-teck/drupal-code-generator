<?php

namespace DrupalCodeGenerator\Tests;

use DrupalCodeGenerator\Application;

/**
 * A test for DCG application.
 */
class ApplicationTest extends BaseTestCase {

  /**
   * Test callback.
   */
  public function testApplication(): void {

    $cmd = sprintf('%s/bin/dcg install -d %s -a Foo -a foo 2>&1', Application::ROOT, $this->directory);
    exec($cmd, $output, $return);

    $expected_output = [
      '',
      ' Welcome to install-file generator!',
      '––––––––––––––––––––––––––––––––––––',
      '',
      ' Module name [Dcg Sandbox]:',
      ' ➤ Foo',
      '',
      ' Module machine name [foo]:',
      ' ➤ foo',
      '',
      ' The following directories and files have been created or updated:',
      '–––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––',
      ' • foo.install',
      '',
    ];
    static::assertEquals($expected_output, $output);
    static::assertEquals(0, $return);
    static::assertFileExists($this->directory . '/foo.install');
  }

}
