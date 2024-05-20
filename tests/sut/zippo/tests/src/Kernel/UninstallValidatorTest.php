<?php

declare(strict_types=1);

namespace Drupal\Tests\zippo\Kernel;

use Drupal\KernelTests\KernelTestBase;
use PHPUnit\Framework\Attributes\Group;

/**
 * Test uninstall validator.
 */
#[Group('DCG')]
final class UninstallValidatorTest extends KernelTestBase {

  /**
   * {@inheritdoc}
   */
  protected static $modules = ['zippo'];

  /**
   * Test callback.
   */
  public function testUninstallValidator(): void {
    $this->expectExceptionMessage('The following reasons prevent the modules from being uninstalled: Some good reason.');
    $this->expectException('Drupal\Core\Extension\ModuleUninstallValidatorException');
    $this->container->get('module_installer')->uninstall(['zippo']);
  }

}
