<?php declare(strict_types = 1);

namespace Drupal\Tests\zippo\Kernel;

use Drupal\KernelTests\KernelTestBase;
use Symfony\Component\HttpFoundation\Request;

/**
 * Middleware test.
 *
 * @group DCG
 */
final class MiddlewareTest extends KernelTestBase {

  /**
   * {@inheritdoc}
   */
  protected static $modules = ['system', 'zippo'];

  /**
   * Test callback.
   */
  public function testMiddleware(): void {
    // Install system config because Fallback datetime format is loaded when
    // 404 exception is logged.
    $this->installConfig(['system']);
    $kernel = $this->container->get('http_kernel');
    $request = new Request(server: ['REQUEST_URI' => '/', 'SCRIPT_NAME' => '']);
    $response = $kernel->handle($request);
    self::assertTrue($response->headers->has('x-middleware-handle-test'));
  }

}
