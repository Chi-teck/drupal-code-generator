<?php

namespace Drupal\foo\PageCache;

use Drupal\Core\PageCache\RequestPolicyInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * A policy disallowing caching of requests with 'no-cache' query parameter.
 *
 * Example: https://example.com/node?no-cache.
 */
class Example implements RequestPolicyInterface {

  /**
   * {@inheritdoc}
   */
  public function check(Request $request) {
    if (!is_null($request->get('no-cache'))) {
      return self::DENY;
    }
  }

}
