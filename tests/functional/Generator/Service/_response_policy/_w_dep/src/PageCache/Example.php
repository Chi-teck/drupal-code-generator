<?php

declare(strict_types=1);

namespace Drupal\foo\PageCache;

use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\PageCache\ResponsePolicyInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @todo Add policy description here.
 */
final class Example implements ResponsePolicyInterface {

  /**
   * Constructs an Example object.
   */
  public function __construct(
    private readonly EntityTypeManagerInterface $entityTypeManager,
  ) {}

  /**
   * {@inheritdoc}
   */
  public function check(Response $response, Request $request): ?string {
    // @DCG
    // Return self::DENY to indicate that the response should not be stored in
    // the cache. Return NULL if the policy does not apply to the given request.
    return NULL;
  }

}
