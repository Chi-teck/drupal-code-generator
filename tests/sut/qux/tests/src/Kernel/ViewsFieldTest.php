<?php

namespace Drupal\Tests\qux\Kernel;

use Drupal\KernelTests\KernelTestBase;
use Drupal\views\ResultRow;

/**
 * Tests views field plugin.
 *
 * @group DCG
 */
class ExampleTest extends KernelTestBase {

  /**
   * {@inheritdoc}
   */
  public static $modules = ['qux', 'views'];

  /**
   * Test callback.
   */
  public function testPlugin() {
    $plugin = \Drupal::service('plugin.manager.views.field')
      ->createInstance('qux_example');

    $plugin->options['prefix'] = '-= ';
    $plugin->options['suffix'] = ' =-';

    $output = $plugin->render(new ResultRow(['unknown' => 'foo']));
    self::assertEquals('-= foo =-', $output);
  }

}
