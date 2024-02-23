<?php

declare(strict_types=1);

namespace Drupal\Tests\zippo\Kernel;

use Drupal\KernelTests\KernelTestBase;
use Drupal\zippo\PageCache\ExampleResponsePolicy;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Response policy test.
 *
 * @group DCG
 */
final class ResponsePolicyTest extends KernelTestBase {

  /**
   * {@inheritdoc}
   */
  protected static $modules = ['zippo', 'example'];

  /**
   * Test callback.
   */
  public function testResponsePolicy(): void {
    // The service is private so we have to instantiate it directly.
    $request_policy = new ExampleResponsePolicy();
    self::assertNull($request_policy->check(new Response(), new Request()));
  }

}
