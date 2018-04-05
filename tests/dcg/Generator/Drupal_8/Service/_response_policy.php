<?php

namespace Drupal\foo\PageCache;

use Drupal\Core\PageCache\ResponsePolicyInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * A policy disallowing caching requests with certain cookies.
 */
class Example implements ResponsePolicyInterface {

  /**
   * {@inheritdoc}
   */
  public function check(Response $response, Request $request) {
    if ($request->cookies->get('foo')) {
      return self::DENY;
    }
  }

}
