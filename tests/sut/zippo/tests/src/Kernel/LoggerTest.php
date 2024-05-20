<?php

declare(strict_types=1);

namespace Drupal\Tests\zippo\Kernel;

use Drupal\KernelTests\KernelTestBase;
use PHPUnit\Framework\Attributes\Group;

/**
 * Logger test.
 */
#[Group('DCG')]
final class LoggerTest extends KernelTestBase {

  /**
   * {@inheritdoc}
   */
  protected static $modules = ['zippo'];

  /**
   * Test callback.
   */
  public function testLogger(): void {
    $this->container
      ->get('logger.factory')
      ->get('zippo')
      ->notice('Foo: {foo}', ['foo' => 'bar']);
    $logged_data = \file_get_contents('temporary://logger_test.log');
    self::assertSame('5 -> Foo: bar', $logged_data);
  }

}
