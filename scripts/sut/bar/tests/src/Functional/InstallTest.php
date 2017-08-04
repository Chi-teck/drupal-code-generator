<?php

namespace Drupal\Tests\bar\Functional;

use Drupal\Tests\BrowserTestBase;

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
    $xpath = '//li[@class = "messages__item" and text() = "bar_install"]';
    $this->assertSession()->elementExists('xpath', $xpath);

    // Test hook_requirements().
    $this->drupalGet('admin/reports/status');
    $xpath = '//details/summary[normalize-space(text()) = "Bar status"]';
    $this->assertSession()->elementExists('xpath', $xpath);

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
    $xpath = '//li[@class = "messages__item" and text() = "bar_uninstall"]';
    $this->assertSession()->elementExists('xpath', $xpath);
  }

}
