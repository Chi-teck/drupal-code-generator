<?php

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
  public static $modules = ['system', 'bar'];

  /**
   * Test callback.
   */
  public function testTemplateRendering(): void {
    $build = ['#theme' => 'example'];
    $this->assertEquals(
      "<div class=\"wrapper-class\">\n  bar\n</div>\n",
      $this->container->get('renderer')->renderRoot($build)
    );
  }

}
