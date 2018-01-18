<?php

namespace DrupalCodeGenerator\Tests;

use DrupalCodeGenerator\ApplicationFactory;

/**
 * A test for DCG application.
 */
class ApplicationTest extends BaseTestCase {

  /**
   * Test callback.
   */
  public function testApplication() {

    $cmd = sprintf(
      ApplicationFactory::getRoot() . '/bin/dcg install -d %s -a \'%s\'',
      $this->directory,
      '{"name":"Foo", "machine_name":"foo"}'
    );
    exec($cmd, $output, $return);

    $expected_output = [
      '',
      ' Welcome to d8:install-file generator!',
      '–––––––––––––––––––––––––––––––––––––––',
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
