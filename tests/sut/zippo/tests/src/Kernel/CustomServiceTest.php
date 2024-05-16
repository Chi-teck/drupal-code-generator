<?php

declare(strict_types=1);

namespace Drupal\Tests\zippo\Kernel;

use Drupal\KernelTests\KernelTestBase;
use PHPUnit\Framework\Attributes\Group;

/**
 * A test form custom service generator.
 */
#[Group('DCG')]
final class CustomServiceTest extends KernelTestBase {

  /**
   * {@inheritdoc}
   */
  protected static $modules = ['zippo'];

  /**
   * Test callback.
   */
  public function testService(): void {
    $foo = $this->container->get('zippo.foo');
    self::assertInstanceOf('Drupal\zippo\Foo', $foo);
    self::assertInstanceOf('Drupal\zippo\FooInterface', $foo);
    self::assertNull($foo->doSomething());
  }

}
