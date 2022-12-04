<?php declare(strict_types = 1);

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
    $plugin = $this->container
      ->get('plugin.manager.views.field')
      ->createInstance('qux_example');

    self::assertInstanceOf('Drupal\qux\Plugin\views\field\Example', $plugin);

    $output = $plugin->render(
      // 'unknown' is a default field alias.
      new ResultRow(['unknown' => 'foo']),
    );
    self::assertEquals('foo', $output);
  }

}
