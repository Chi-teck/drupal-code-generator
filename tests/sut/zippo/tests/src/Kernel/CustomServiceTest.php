<?php

namespace Drupal\Tests\zippo\Kernel;

use Drupal\KernelTests\KernelTestBase;

/**
 * CustomServiceTest test.
 *
 * @group DCG
 */
class CustomServiceTest extends KernelTestBase {

  /**
   * {@inheritdoc}
   */
  public static $modules = ['zippo', 'example'];

  /**
   * Test callback.
   */
  public function testService() {
    $foo = \Drupal::service('zippo.foo');
    self::assertInstanceOf('Drupal\zippo\Foo', $foo);
    self::assertNull($foo->doSomething());
  }

}
