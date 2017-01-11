<?php

namespace Drupal\Tests\foo\Functional;

use Drupal\Tests\BrowserTestBase;

/**
 * Example test.
 *
 * @group foo
 */
class ExampleTest extends BrowserTestBase {

  /**
   * {@inheritdoc}
   */
  public static $modules = ['node'];

  /**
   * Tests content page.
   */
  public function testActionUninstall() {
    $admin_user = $this->drupalCreateUser(['administer nodes']);
    $this->drupalLogin($admin_user);
    $this->drupalGet('admin/content');
    $this->assertSession()->pageTextContains('Content');
  }

}
