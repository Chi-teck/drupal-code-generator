<?php

namespace Drupal\Tests\qux\Kernel;

use Drupal\KernelTests\KernelTestBase;
use Drupal\Core\Database\Database;

/**
 * Test for menu link plugin.
 *
 * @group DCG
 */
class MenuLinkTest extends KernelTestBase {

  /**
   * {@inheritdoc}
   */
  public static $modules = ['qux'];

  /**
   * Test callback.
   */
  public function testMenuLink() {

    /** @var \Drupal\Core\Menu\MenuLinkManagerInterface $plugin_manager */
    $plugin_manager = \Drupal::service('plugin.manager.menu.link');
    $plugin_manager->rebuild();

    $plugin = $plugin_manager->createInstance('qux.test');

    $db_connection = Database::getConnection();

    // Create a table for testing form submission.
    $table['fields']['id']['type'] = 'int';
    $db_connection->schema()->createTable('messages', $table);

    $this->assertEquals('Messages (0)', $plugin->getTitle());
    $db_connection->insert('messages')->fields(['id' => 1])->execute();

    $this->assertEquals('Messages (1)', $plugin->getTitle());
    $this->assertEquals('qux.messages', $plugin->getRouteName());

    $this->assertEquals(['qux.messages_count'], $plugin->getCacheTags());
  }

}
