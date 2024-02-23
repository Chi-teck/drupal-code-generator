<?php

declare(strict_types=1);

namespace Drupal\Tests\bar\Kernel;

use Drupal\KernelTests\KernelTestBase;

/**
 * Hook test.
 *
 * @group DCG
 */
final class HookTest extends KernelTestBase {

  /**
   * {@inheritdoc}
   */
  protected static $modules = ['bar'];

  /**
   * Test callback.
   *
   * @see \hook_countries_alter()
   */
  public function testHook(): void {
    $countries = $this->container
      ->get('country_manager')
      ->getList();
    self::assertArrayHasKey('EB', $countries);
    self::assertSame('Elbonia', $countries['EB']);
  }

}
