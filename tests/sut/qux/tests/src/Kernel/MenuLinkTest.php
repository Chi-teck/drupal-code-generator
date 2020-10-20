<?php

namespace Drupal\Tests\qux\Kernel;

use Drupal\Core\Database\Database;
use Drupal\KernelTests\KernelTestBase;

/**
 * Test for menu link plugin.
 *
 * @group DCG
 */
final class MenuLinkTest extends KernelTestBase {

  /**
   * {@inheritdoc}
   */
  protected static $modules = ['qux'];

  /**
   * Test callback.
   */
  public function testMenuLink(): void {

    /** @var \Drupal\Core\Menu\MenuLinkManagerInterface $plugin_manager */
    $plugin_manager = \Drupal::service('plugin.manager.menu.link');
    $plugin_manager->rebuild();

    $plugin = $plugin_manager->createInstance('qux.test');

    $db_connection = Database::getConnection();

    // Create a table for testing form submission.
    $table['fields']['id']['type'] = 'int';
    $db_connection->schema()->createTable('messages', $table);

    self::assertEquals('Messages (0)', $plugin->getTitle());
    $db_connection->insert('messages')->fields(['id' => 1])->execute();

    self::assertEquals('Messages (1)', $plugin->getTitle());
    self::assertSame('qux.messages', $plugin->getRouteName());

    self::assertSame(['qux.messages_count'], $plugin->getCacheTags());
  }

}
