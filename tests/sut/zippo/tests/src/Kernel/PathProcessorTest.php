<?php declare(strict_types = 1);

namespace Drupal\Tests\zippo\Kernel;

use Drupal\KernelTests\KernelTestBase;
use Symfony\Component\HttpFoundation\Request;

/**
 * Path processor test.
 *
 * @group DCG
 */
final class PathProcessorTest extends KernelTestBase {

  /**
   * {@inheritdoc}
   */
  protected static $modules = ['zippo', 'example'];

  /**
   * Test callback.
   */
  public function testPathProcessor(): void {
    $manager = \Drupal::service('path_processor_manager');

    $request = Request::create('/content/1');
    $path = $manager->processInbound('/content/1', $request);
    self::assertSame('/node/1', $path);

    $path = $manager->processOutbound('/node/1');
    self::assertSame('/content/1', $path);
  }

}
