<?php

declare(strict_types=1);

namespace Drupal\example\PathProcessor;

use Drupal\Core\Database\Connection;
use Drupal\Core\PathProcessor\InboundPathProcessorInterface;
use Drupal\Core\PathProcessor\OutboundPathProcessorInterface;
use Drupal\Core\Render\BubbleableMetadata;
use Symfony\Component\HttpFoundation\Request;

/**
 * Path processor to replace 'node' with 'content' in URLs.
 *
 * @DCG In case you need to implement only one processor (inbound or outbound)
 * remove the corresponding interface, method and service tag.
 */
final class PathProcessorExample implements InboundPathProcessorInterface, OutboundPathProcessorInterface {

  /**
   * Constructs a PathProcessorExample object.
   */
  public function __construct(
    private readonly Connection $connection,
  ) {}

  /**
   * {@inheritdoc}
   */
  public function processInbound($path, Request $request): string {
    return preg_replace('#^/content/#i', '/node/', $path);
  }

  /**
   * {@inheritdoc}
   */
  public function processOutbound($path, &$options = [], Request $request = NULL, BubbleableMetadata $bubbleable_metadata = NULL): string {
    return preg_replace('#^/node/#i', '/content/', $path);
  }

}
