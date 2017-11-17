<?php

namespace DrupalCodeGenerator\Tests;

use PHPUnit\Framework\TestCase;

/**
 * A test for DCG application.
 */
class ApplicationTest extends TestCase {

  use WorkingDirectoryTrait;

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    $this->initWorkingDirectory();
  }

  /**
   * {@inheritdoc}
   */
  public function tearDown() {
    $this->removeWorkingDirectory();
  }

  /**
   * Test callback.
   */
  public function testApplication() {

    $cmd = sprintf(DCG_ROOT . '/bin/dcg install --directory=%s -a\'%s\'', $this->directory, '{"name":"Foo", "machine_name":"foo"}');
    exec($cmd, $output, $return);

    $expected_output = [
      '',
      'The following directories and files have been created or updated:',
      '–––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––',
      '• foo.install',
    ];
    static::assertEquals($expected_output, $output);
    static::assertEquals(0, $return);
    static::assertFileExists($this->directory . '/foo.install');
  }

}
