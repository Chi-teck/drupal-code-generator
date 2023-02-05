<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Tests\Functional;

use DrupalCodeGenerator\Test\Functional\FunctionalTestBase;

/**
 * Test DCG application.
 *
 * @todo Clean-up
 */
final class ApplicationTest extends FunctionalTestBase {

  /**
   * Test callback.
   */
  public function testApplication(): void {
    $cmd = \sprintf(
      '%s/vendor/bin/dcg install --working-dir %s --destination %s -a example -a Example 2>&1',
      \DRUPAL_ROOT,
      $this->directory,
      $this->directory,
    );
    \exec($cmd, $output, $return);

    $expected_output = <<< 'TEXT'
    
     Welcome to install-file generator!
    ––––––––––––––––––––––––––––––––––––

     Module machine name:
     ➤ example

     Module name [Example]:
     ➤ Example
    
     The following directories and files have been created or updated:
    –––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
     • example.info.yml
     • example.install

    TEXT;

    self::assertSame($expected_output, \implode("\n", $output));
    self::assertSame(0, $return);
    self::assertFileExists($this->directory . '/example.install');
  }

}
