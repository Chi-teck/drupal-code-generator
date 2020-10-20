<?php

namespace Drupal\Tests\qux\Functional;

use Drupal\dcg_test\TestTrait;
use Drupal\Tests\BrowserTestBase;

/**
 * Block plugin test.
 *
 * @group DCG
 */
final class BlockTest extends BrowserTestBase {

  use TestTrait;

  /**
   * {@inheritdoc}
   */
  protected static $modules = ['qux', 'block'];

  /**
   * {@inheritdoc}
   */
  protected $defaultTheme = 'stark';

  /**
   * Test callback.
   */
  public function testBlock(): void {
    $permissions = ['administer blocks', 'administer themes'];
    $admin_user = $this->drupalCreateUser($permissions);
    $this->drupalLogin($admin_user);
    $this->drupalGet('admin/structure/block/library/stark');
    $link_xpath = '//td[. = "Example"]/following-sibling::td[text() = "DCG"]';
    $link_xpath .= '/following-sibling::td//a[text() = "Place block"]';

    $this->getSession()->getDriver()->click($link_xpath);

    // Check default configuration.
    $this->assertXpath('//input[@name = "settings[label]" and @value = "Example"]');
    $this->assertXpath('//textarea[@name = "settings[foo]" and text() = "Hello world!"]');

    // Update block configuration.
    $edit = [
      'settings[label]' => 'Beer',
      'settings[foo]' => 'Wine',
      'region' => 'sidebar_first',
    ];
    $this->drupalPostForm(NULL, $edit, 'Save block');
    $this->assertSession()->responseContains('The block configuration has been saved.');

    // Make sure the configuration has been persisted.
    $this->drupalGet('admin/structure/block/manage/example');
    $this->assertXpath('//input[@name = "settings[label]" and @value = "Beer"]');
    $this->assertXpath('//textarea[@name = "settings[foo]" and text() = "Wine"]');

    // Render the block.
    $this->drupalGet('<front>');
    $this->assertSession()->responseContains('Beer');
    $this->assertSession()->responseContains('It works!');
  }

}
