<?php declare(strict_types = 1);

namespace Drupal\foo\Cache\Context;

use Drupal\Core\Cache\CacheableMetadata;
use Drupal\Core\Cache\Context\CacheContextInterface;
use Drupal\Core\Cache\Context\RequestStackCacheContextBase;

/**
 * @todo Add a description for the cache context.
 *
 * Cache context ID: 'example'.
 *
 * @DCG
 * Check out the core/lib/Drupal/Core/Cache/Context directory for examples of
 * cache contexts provided by Drupal core.
 */
final class ExampleCacheContext extends RequestStackCacheContextBase implements CacheContextInterface {

  /**
   * {@inheritdoc}
   */
  public static function getLabel(): string {
    return (string) t('Example');
  }

  /**
   * {@inheritdoc}
   */
  public function getContext(): string {
    // @todo Calculate the cache context here.
    $context = 'some_string_value';
    return $context;
  }

  /**
   * {@inheritdoc}
   */
  public function getCacheableMetadata(): CacheableMetadata {
    return new CacheableMetadata();
  }

}
