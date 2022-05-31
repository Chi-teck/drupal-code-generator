<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Tests\Functional;

use DrupalCodeGenerator\Test\Functional\FunctionalTestBase;
use Symfony\Component\Filesystem\Filesystem;

/**
 * Test DCG application.
 *
 * @todo Clean-up
 */
final class ApplicationTest extends FunctionalTestBase {

  /**
   * {@inheritdoc}
   */
  public function setUp(): void {
    parent::setUp();
    $this->directory = \sys_get_temp_dir() . '/dcg_sandbox';
  }

  /**
   * {@inheritdoc}
   */
  public function tearDown(): void {
    parent::tearDown();
    (new Filesystem())->remove($this->directory);
  }

  /**
   * Test callback.
   */
  public function testApplication(): void {

    $cmd = \sprintf(
      '%s/vendor/bin/dcg install --working-dir %s --destination %s -a action 2>&1',
      \getcwd(),
      $this->directory,
      $this->directory,
    );
    \exec($cmd, $output, $return);

    $expected_output = <<< 'TEXT'
    
     Welcome to install-file generator!
    ––––––––––––––––––––––––––––––––––––

     Module machine name:
     ➤ action
    
     The following directories and files have been created or updated:
    –––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
     • action.install

    TEXT;

    self::assertSame($expected_output, \implode("\n", $output));
    self::assertSame(0, $return);
    self::assertFileExists($this->directory . '/action.install');
  }

}
