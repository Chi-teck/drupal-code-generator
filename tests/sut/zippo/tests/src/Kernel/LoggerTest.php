<?php

namespace Drupal\Tests\zippo\Kernel;

use Drupal\KernelTests\KernelTestBase;

/**
 * Logger test.
 *
 * @group DCG
 */
final class LoggerTest extends KernelTestBase {

  /**
   * {@inheritdoc}
   */
  public static $modules = ['system', 'zippo', 'example'];

  /**
   * Test callback.
   */
  public function testLogger(): void {

    $this->installConfig('system');

    \Drupal::logger('zippo')->notice('foo');

    $logged_data = \file_get_contents('temporary://drupal.log');

    self::assertRegExp('/\[message\] => foo\n/', $logged_data);
    self::assertRegExp('/\[type\] => zippo\n/', $logged_data);
    self::assertRegExp('/\[severity\] => Notice\n/', $logged_data);
  }

}
