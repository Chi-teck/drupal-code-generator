<?php declare(strict_types = 1);

namespace Drupal\Tests\acme\Kernel;

use Drupal\acme\Entity\User\UserBase;
use Drupal\acme\Entity\User\UserBundle;
use Drupal\KernelTests\KernelTestBase;

/**
 * A test for generated bundle classes.
 *
 * @group acme
 */
final class BundleClassTest extends KernelTestBase {

  /**
   * {@inheritdoc}
   */
  protected static $modules = ['acme', 'user'];

  /**
   * Test callback.
   */
  public function testBundleClass(): void {
    $user = $this->container
      ->get('entity_type.manager')
      ->getStorage('user')
      ->create();
    self::assertInstanceOf(UserBundle::class, $user);
    self::assertInstanceOf(UserBase::class, $user);
  }

}
