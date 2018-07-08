<?php

namespace Drupal\Tests\zippo\Kernel;

use Drupal\KernelTests\KernelTestBase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Response policy test.
 *
 * @group DCG
 */
class ResponsePolicyTest extends KernelTestBase {

  /**
   * {@inheritdoc}
   */
  public static $modules = ['zippo', 'example'];

  /**
   * Test callback.
   */
  public function testResponsePolicy() {
    // The service is private so we have to test it implicitly through service
    // collector.
    $request_policy = \Drupal::service('page_cache_response_policy');
    $response = new Response();
    $request = new Request();
    self::assertNull($request_policy->check($response, $request));
    $request->cookies->set('foo', 'bar');
    self::assertEquals('deny', $request_policy->check($response, $request));
  }

}
