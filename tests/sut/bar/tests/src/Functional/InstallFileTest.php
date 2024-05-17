<?php

declare(strict_types=1);

namespace Drupal\Tests\bar\Functional;

use Drupal\dcg_test\TestTrait;
use Drupal\Tests\BrowserTestBase;

/**
 * Test install file.
 *
 * @group DCG
 */
final class InstallFileTest extends BrowserTestBase {

  use TestTrait;

  /**
   * {@inheritdoc}
   */
  protected $defaultTheme = 'stark';

  /**
   * Test callback.
   */
  public function testInstall(): void {
    if (\version_compare(\Drupal::VERSION, '10.3', '<')) {
      self::markTestSkipped();
    }

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
    $this->assertStatusMessage('Module Bar has been installed.');

    // Test hook_uninstall().
    $this->drupalGet('admin/modules/uninstall');
    $edit = [
      'uninstall[bar]' => TRUE,
    ];
    $this->submitForm($edit, 'Uninstall');
    $this->submitForm([], 'Uninstall');
    $this->assertStatusMessage('Module Bar has been uninstalled.');
  }

}
