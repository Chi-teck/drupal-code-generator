<?php declare(strict_types = 1);

namespace Drupal\Tests\nigma\Kernel;

use Drupal\KernelTests\KernelTestBase;

/**
 * Tests actions for example entity type.
 *
 * @group nigma
 */
final class ActionsTest extends KernelTestBase {

  /**
   * {@inheritdoc}
   */
  protected static $modules = ['system', 'nigma'];

  /**
   * Test callback.
   */
  public function testActions(): void {
    // Test that action plugins have been registered for the entity type.
    $action_manager = $this->container->get('plugin.manager.action');
    self::assertTrue($action_manager->hasDefinition('entity:delete_action:example'));
    self::assertTrue($action_manager->hasDefinition('entity:save_action:example'));

    // Make sure that module actions have been installed.
    $this->installConfig('nigma');
    $action_storage = $this->container
      ->get('entity_type.manager')
      ->getStorage('action');
    self::assertSame('Delete examples', $action_storage->load('example_delete_action')->label());
    self::assertSame('Save examples', $action_storage->load('example_save_action')->label());
  }

}
