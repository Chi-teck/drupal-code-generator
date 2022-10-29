<?php declare(strict_types = 1);

namespace Drupal\foo;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\HttpKernelInterface;

/**
 * @todo Add a description for the middleware.
 */
final class BarMiddleware implements HttpKernelInterface {

  /**
   * Constructs a BarMiddleware object.
   */
  public function __construct(
    private readonly HttpKernelInterface $httpKernel,
  ) {}

  /**
   * {@inheritdoc}
   */
  public function handle(Request $request, $type = self::MAIN_REQUEST, $catch = TRUE): Response {
    // @todo Modify the request here.
    $response = $this->httpKernel->handle($request, $type, $catch);
    // @todo Modify the response here.
    return $response;
  }

}
