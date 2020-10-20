<?php

namespace Drupal\Tests\qux\Kernel;

use Drupal\KernelTests\KernelTestBase;
use Drupal\views\ResultRow;

/**
 * Tests views field plugin.
 *
 * @group DCG
 */
final class ViewsFieldTest extends KernelTestBase {

  /**
   * {@inheritdoc}
   */
  protected static $modules = ['qux', 'views'];

  /**
   * Test callback.
   */
  public function testPlugin(): void {
    $plugin = \Drupal::service('plugin.manager.views.field')
      ->createInstance('qux_example');

    // The option isn't used anywhere.
    $plugin->options['example'] = 'bar';

    $output = $plugin->render(new ResultRow(['unknown' => 'foo']));
    self::assertEquals('foo', $output);
  }

}
