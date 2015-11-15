<?php

/**
 * @file
 * Contains \Drupal\foo\FooMiddleware.
 */

namespace Drupal\foo;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\HttpKernelInterface;

class FooMiddleware implements HttpKernelInterface {

  /**
   * The kernel.
   *
   * @var HttpKernelInterface
   */
  protected $httpKernel;

  /**
   * Constructs a FooMiddleware object.
   *
   * @param HttpKernelInterface $http_kernel
   *   The decorated kernel.
   */
  public function __construct(HttpKernelInterface $http_kernel) {
    $this->httpKernel = $http_kernel;
  }

  /**
   * {@inheritdoc}
   */
  public function handle(Request $request, $type = self::MASTER_REQUEST, $catch = TRUE) {

    if ($request->getClientIp() == '127.0.0.10') {
      return new Response(t('Bye!'), 403);
    }

    return $this->httpKernel->handle($request, $type, $catch);
  }

}
