<?php

namespace Drupal\Tests\zippo\Kernel;

use Drupal\KernelTests\KernelTestBase;

/**
 * Test uninstall validator.
 *
 * @group DCG
 */
class UninstallValidatorTest extends KernelTestBase {

  /**
   * {@inheritdoc}
   */
  public static $modules = ['block', 'system', 'help', 'zippo'];

  /**
   * Test callback.
   */
  public function testUninstallValidator() {

    $this->container
      ->get('entity_type.manager')
      ->getStorage('block')
      ->create([
        'id' => 'test_block',
        'plugin' => 'help_block',
      ])
      ->save();

    $this->expectExceptionMessage('The following reasons prevent the modules from being uninstalled: Provides a block plugin that is in use in the following block: <a href="/admin/structure/block/manage/test_block">test_block</a>');
    $this->expectException('Drupal\Core\Extension\ModuleUninstallValidatorException');
    $this->container->get('module_installer')->uninstall(['help']);
  }

}
