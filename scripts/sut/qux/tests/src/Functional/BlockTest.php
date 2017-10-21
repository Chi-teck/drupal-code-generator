<?php

namespace Drupal\Tests\qux\Functional;

use TestBase\BrowserTestBase;

/**
 * Block plugin test.
 *
 * @group DCG
 */
class BlockTest extends BrowserTestBase {

  /**
   * {@inheritdoc}
   */
  public static $modules = ['qux', 'block'];

  /**
   * {@inheritdoc}
   */
  protected $strictConfigSchema = FALSE;

  /**
   * Test callback.
   */
  public function testContentPage() {
    $admin_user = $this->drupalCreateUser(['administer blocks', 'administer themes']);
    $this->drupalLogin($admin_user);
    $this->drupalGet('admin/structure/block/library/classy');
    $link_xpath = '//td[. = "Example"]/following-sibling::td[text() = "DCG"]';
    $link_xpath .= '/following-sibling::td//a[text() = "Place block"]';
    $this->click($link_xpath);

    // Check default configuration.
    $this->assertXpath('//input[@name = "settings[label]" and @value = "Example"]');
    $this->assertXpath('//textarea[@name = "settings[content]" and text() = "Hello world!"]');

    // Update block configuration.
    $edit = [
      'settings[label]' => 'Beer',
      'settings[content]' => 'Wine',
      'region' => 'sidebar_first',
    ];
    $this->drupalPostForm(NULL, $edit, 'Save block');
    $this->assertSession()->responseContains('The block configuration has been saved.');

    // Make sure the configuration has been persisted.
    $this->drupalGet('admin/structure/block/manage/example');
    $this->assertXpath('//input[@name = "settings[label]" and @value = "Beer"]');
    $this->assertXpath('//textarea[@name = "settings[content]" and text() = "Wine"]');

    // The block should appear only for anonymous users.
    $this->drupalGet('<front>');
    $this->assertSession()->responseNotContains('Beer');
    $this->assertSession()->responseNotContains('Wine');
    $this->drupalLogout();
    $this->assertSession()->responseContains('Beer');
    $this->assertSession()->responseContains('Wine');
  }

}
