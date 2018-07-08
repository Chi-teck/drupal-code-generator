<?php

namespace Drupal\Tests\zippo\Kernel;

use Drupal\Core\StreamWrapper\PublicStream;
use Drupal\KernelTests\KernelTestBase;

/**
 * Logger test.
 *
 * @group DCG
 */
class LoggerTest extends KernelTestBase {

  /**
   * {@inheritdoc}
   */
  public static $modules = ['system', 'zippo', 'example'];

  /**
   * Test callback.
   */
  public function testLogger() {

    $this->installConfig('system');

    $file_public_path = PublicStream::basePath();

    \Drupal::configFactory()
      ->getEditable('system.file')
      // Set temporary path same as public path, so the generated log file is
      // removed along with Drupal installation.
      ->set('path.temporary', $file_public_path)
      ->save();

    \Drupal::logger('zippo')->notice('foo');

    $logged_data = file_get_contents($file_public_path . '/drupal.log');

    self::assertRegExp('/\[message\] => foo\n/', $logged_data);
    self::assertRegExp('/\[type\] => zippo\n/', $logged_data);
    self::assertRegExp('/\[severity\] => Notice\n/', $logged_data);
  }

}
