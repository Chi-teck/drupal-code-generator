<?php

namespace Drupal\Tests\bar\Functional;

use Drupal\dcg_test\TestTrait;
use Drupal\Tests\BrowserTestBase;

/**
 * Test install file.
 *
 * @group DCG
 */
final class InstallTest extends BrowserTestBase {

  use TestTrait;

  /**
   * {@inheritdoc}
   */
  protected $defaultTheme = 'stark';

  /**
   * Test callback.
   */
  public function testInstall(): void {
    $permissions = ['administer modules', 'administer site configuration'];
    $user = $this->drupalCreateUser($permissions);
    $this->drupalLogin($user);

    // Test hook_install().
    $this->drupalGet('admin/modules');
    $edit = [
      'modules[example][enable]' => TRUE,
      'modules[bar][enable]' => TRUE,
    ];
    $this->submitForm($edit, 'Install');
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
    self::assertEquals(['id' => 1] + $fields, $data);

    // Test hook_uninstall().
    $this->drupalGet('admin/modules/uninstall');
    $edit = [
      'uninstall[bar]' => TRUE,
    ];
    $this->submitForm($edit, 'Uninstall');
    $this->submitForm([], 'Uninstall');
    $this->assertStatusMessage('bar_uninstall');
  }

}
