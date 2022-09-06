<?php declare(strict_types = 1);

namespace Drupal\Tests\bar\Kernel;

use Drupal\KernelTests\KernelTestBase;

/**
 * Template test.
 *
 * @group DCG
 */
final class TemplateTest extends KernelTestBase {

  /**
   * {@inheritdoc}
   */
  protected static $modules = ['system', 'bar'];

  /**
   * Test callback.
   */
  public function testTemplateRendering(): void {
    $build = ['#theme' => 'example'];
    self::assertEquals(
      "<div class=\"wrapper-class\">\n  bar\n</div>\n",
      $this->container->get('renderer')->renderRoot($build),
    );
  }

}
