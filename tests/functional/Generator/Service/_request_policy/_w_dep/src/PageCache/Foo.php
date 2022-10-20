<?php declare(strict_types = 1);

namespace Drupal\example\PageCache;

use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\PageCache\RequestPolicyInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * @todo Add policy description here.
 */
final class Foo implements RequestPolicyInterface {

  /**
   * Constructs a Foo object.
   */
  public function __construct(
    private readonly EntityTypeManagerInterface $entityTypeManager,
  ) {}

  /**
   * {@inheritdoc}
   */
  public function check(Request $request): ?string {
    // @DCG
    // Return self::ALLOW or self::DENY to indicate whether delivery of a cached
    // page should be attempted for this request. Return NULL if the policy does
    // not apply to the given request.
    return NULL;
  }

}
