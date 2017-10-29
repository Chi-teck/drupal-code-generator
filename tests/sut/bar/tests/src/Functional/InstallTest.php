<?php

namespace Drupal\Tests\bar\Functional;

use TestBase\BrowserTestBase;

/**
 * Test install file.
 *
 * @group DCG
 */
class InstallTest extends BrowserTestBase {

  /**
   * Test callback.
   */
  public function testInstall() {
    $user = $this->drupalCreateUser(['administer modules', 'administer site configuration']);
    $this->drupalLogin($user);

    // Test hook_install().
    $edit = [
      'modules[bar][enable]' => TRUE,
    ];
    $this->drupalPostForm('admin/modules', $edit, 'Install');
    $this->assertStatusMessage('bar_install');

    // Test hook_requirements().
    $this->drupalGet('admin/reports/status');
    $this->assertXpath('//details/summary[normalize-space(text()) = "Bar status"]');

    // Test hook_schema().
    $fields = [
      'uid' => 1,
      'status' => TRUE,
      'type' => 'example',
      'created' => 123456789,
      'data' => 'abcdefgh',
    ];
    $database = \Drupal::database();
    $database->insert('bar_example')->fields($fields)->execute();
    $data = $database->query('SELECT * FROM {bar_example}')->fetchAssoc();
    $this->assertEquals(['id' => 1] + $fields, $data);

    // Test hook_uninstall().
    $edit = [
      'uninstall[bar]' => TRUE,
    ];
    $this->drupalPostForm('admin/modules/uninstall', $edit, 'Uninstall');
    $this->drupalPostForm(NULL, [], 'Uninstall');
    $this->assertStatusMessage('bar_uninstall');
  }

}
