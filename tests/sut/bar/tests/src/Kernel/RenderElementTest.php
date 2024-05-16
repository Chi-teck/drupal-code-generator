<?php

declare(strict_types=1);

namespace Drupal\Tests\bar\Kernel;

use Drupal\KernelTests\KernelTestBase;
use PHPUnit\Framework\Attributes\Group;

/**
 * Render element test.
 */
#[Group('DCG')]
final class RenderElementTest extends KernelTestBase {

  /**
   * {@inheritdoc}
   */
  protected static $modules = ['bar'];

  /**
   * Test callback.
   */
  public function testElementRendering(): void {
    $renderer = $this->container->get('renderer');

    $build = [
      '#type' => 'example',
    ];
    $result = $renderer->renderRoot($build);
    self::assertEquals('bar', $result);

    $build = [
      '#type' => 'example',
      '#foo' => 'Hello world!',
    ];
    $result = $renderer->renderRoot($build);
    self::assertEquals('Hello world!', $result);
  }

}
