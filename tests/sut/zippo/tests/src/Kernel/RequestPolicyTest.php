<?php declare(strict_types = 1);

namespace Drupal\Tests\zippo\Kernel;

use Drupal\KernelTests\KernelTestBase;
use Symfony\Component\HttpFoundation\Request;

/**
 * Request policy test.
 *
 * @group DCG
 */
final class RequestPolicyTest extends KernelTestBase {

  /**
   * {@inheritdoc}
   */
  protected static $modules = ['zippo', 'example'];

  /**
   * Test callback.
   */
  public function testRequestPolicy(): void {
    $request_policy = \Drupal::service('zippo.page_cache_request_policy.example');
    self::assertNull($request_policy->check(new Request()));
    self::assertSame('deny', $request_policy->check(new Request(['no-cache' => 1])));
  }

}
