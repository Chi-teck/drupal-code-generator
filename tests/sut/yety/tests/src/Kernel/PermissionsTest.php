<?php

declare(strict_types=1);

namespace Drupal\Tests\yety\Kernel;

use Drupal\KernelTests\KernelTestBase;
use PHPUnit\Framework\Attributes\Group;

/**
 * Tests permissions.yml.
 */
#[Group('DCG')]
final class PermissionsTest extends KernelTestBase {

  /**
   * {@inheritdoc}
   */
  protected static $modules = ['yety', 'user'];

  /**
   * Test callback.
   */
  public function testPermissions(): void {
    $permissions = $this->container
      ->get('user.permissions')
      ->getPermissions();
    self::assertArrayHasKey('administer yety configuration', $permissions);

    $expected_permission = [
      'title' => 'Administer yety configuration',
      'description' => 'Optional description.',
      'restrict access' => TRUE,
      'provider' => 'yety',
    ];
    $permission = $permissions['administer yety configuration'];
    $permission['title'] = (string) $permission['title'];
    $permission['description'] = (string) $permission['description'];
    self::assertSame($expected_permission, $permission);
  }

}
