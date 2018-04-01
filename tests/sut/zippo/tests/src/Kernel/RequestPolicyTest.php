<?php

namespace Drupal\Tests\xxx\Kernel;

use Drupal\KernelTests\KernelTestBase;
use Symfony\Component\HttpFoundation\Request;

/**
 * Request policy test.
 *
 * @group DCG
 */
class RequestPolicyTest extends KernelTestBase {

  /**
   * {@inheritdoc}
   */
  public static $modules = ['zippo'];

  /**
   * Test callback.
   */
  public function testRequestPolicy() {
    $request_policy = \Drupal::service('zippo.page_cache_request_policy.example');
    self::assertNull($request_policy->check(new Request()));
    self::assertEquals('deny', $request_policy->check(new Request(['no-cache' => 1])));
  }

}
