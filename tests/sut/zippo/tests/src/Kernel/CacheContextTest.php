<?php

namespace Drupal\Tests\zippo\Kernel;

use Drupal\Core\Cache\CacheableMetadata;
use Drupal\KernelTests\KernelTestBase;

/**
 * Test cache context service.
 *
 * @group DCG
 */
final class CacheContextTest extends KernelTestBase {

  /**
   * {@inheritdoc}
   */
  public static $modules = ['system', 'zippo', 'example'];

  /**
   * Test callback.
   */
  public function testCacheContext(): void {
    $cache_context = \Drupal::service('cache_context.example');
    self::assertEquals('Example', $cache_context->getLabel());
    self::assertSame('some_string_value', $cache_context->getContext());
    self::assertEquals(new CacheableMetadata(), $cache_context->getCacheableMetadata());
  }

}
