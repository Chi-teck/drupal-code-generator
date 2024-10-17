<?php

declare(strict_types=1);

namespace Drupal\Tests\bar\Functional;

use Drupal\Tests\BrowserTestBase;
use Drupal\dcg_test\TestTrait;
use PHPUnit\Framework\Attributes\Group;

/**
 * Test install file.
 */
#[Group('DCG')]
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
