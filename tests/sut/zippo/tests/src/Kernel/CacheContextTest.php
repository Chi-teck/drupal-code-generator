<?php

declare(strict_types=1);

namespace Drupal\Tests\zippo\Kernel;

use Drupal\Core\Cache\CacheableMetadata;
use Drupal\KernelTests\KernelTestBase;
use PHPUnit\Framework\Attributes\Group;

/**
 * Test cache context service.
 */
#[Group('DCG')]
final class CacheContextTest extends KernelTestBase {

  /**
   * {@inheritdoc}
   */
  protected static $modules = ['zippo'];

  /**
   * Test callback.
   */
  public function testCacheContext(): void {
    $cache_context = $this->container->get('cache_context.example');
    self::assertSame('Example', $cache_context::class::getLabel());
    self::assertSame('some_string_value', $cache_context->getContext());
    self::assertEquals(new CacheableMetadata(), $cache_context->getCacheableMetadata());
  }

}
