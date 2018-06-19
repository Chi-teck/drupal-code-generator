<?php

namespace Drupal\Tests\zippo\Kernel;

use Drupal\Core\Cache\CacheableMetadata;
use Drupal\KernelTests\KernelTestBase;

/**
 * Test cache context service.
 *
 * @group DCG
 */
class CacheContextTest extends KernelTestBase {

  /**
   * {@inheritdoc}
   */
  public static $modules = ['system', 'zippo'];

  /**
   * Test callback.
   */
  public function testCacheContext() {
    $cache_context = \Drupal::service('cache_context.example');
    $this->assertEquals('Example', $cache_context->getLabel());
    $this->assertEquals('some_string_value', $cache_context->getContext());
    $this->assertEquals(new CacheableMetadata(), $cache_context->getCacheableMetadata());
  }

}
