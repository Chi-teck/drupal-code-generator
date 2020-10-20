<?php

namespace Drupal\Tests\zippo\Kernel;

use Drupal\KernelTests\KernelTestBase;

/**
 * A test form custom service generator.
 *
 * @group DCG
 */
final class CustomServiceTest extends KernelTestBase {

  /**
   * {@inheritdoc}
   */
  protected static $modules = ['zippo', 'example'];

  /**
   * Test callback.
   */
  public function testService(): void {
    $foo = \Drupal::service('zippo.foo');
    self::assertInstanceOf('Drupal\zippo\Foo', $foo);
    self::assertNull($foo->doSomething());
  }

}
