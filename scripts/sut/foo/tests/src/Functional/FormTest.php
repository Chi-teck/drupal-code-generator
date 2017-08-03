<?php

namespace Drupal\Tests\foo\Functional;

use Drupal\Core\Database\Database;
use Drupal\Tests\BrowserTestBase;

/**
 * Form test.
 *
 * @group DCG
 */
class FormTest extends BrowserTestBase {

  /**
   * {@inheritdoc}
   */
  public static $modules = ['foo'];

  /**
   * {@inheritdoc}
   */
  protected function setUp() {
    parent::setUp();
    $admin_user = $this->drupalCreateUser(['access administration pages']);
    $this->drupalLogin($admin_user);
  }

  /**
   * Test callback.
   */
  public function testSimpleForm() {
    $this->drupalGet('admin/config/foo/simple');
    $prefix = '//form[@id="foo-simple"]';
    $this->assertXpath($prefix . '//label[text() = "Message"]');
    $this->assertXpath($prefix . '//textarea[@name = "message"]');
    $this->assertXpath($prefix . '//input[@type = "submit" and @value = "Save"]');

    $edit = [
      'message' => 123456789,
    ];
    $this->drupalPostForm(NULL, $edit, 'Save');
    $this->assertXpath('//div[contains(., "Message should be at least 10 characters.")]');

    $edit = [
      'message' => 1234567890,
    ];
    $this->drupalPostForm(NULL, $edit, 'Save');
    $this->assertXpath('//div[contains(., "The message has been sent.")]');
  }

  /**
   * Test callback.
   */
  public function testConfigForm() {
    $this->drupalGet('admin/config/foo/settings');
    $prefix = '//form[@id="foo-config"]';
    $this->assertXpath($prefix . '//label[text() = "Example"]');
    $this->assertXpath($prefix . '//input[@name = "example" and @value="none"]');
    $this->assertXpath($prefix . '//input[@type = "submit" and @value = "Save configuration"]');
    $edit = [
      'example' => 'Some text.',
    ];
    $this->drupalPostForm(NULL, $edit, 'Save configuration');
    $this->assertXpath('//div[contains(., "The value is not correct.")]');

    $edit = [
      'example' => 'example',
    ];
    $this->drupalPostForm(NULL, $edit, 'Save configuration');
    $this->assertXpath('//div[contains(., "The configuration options have been saved.")]');
    $this->assertXpath($prefix . '//input[@name = "example" and @value="example"]');
  }

  /**
   * Test callback.
   */
  public function testConfirmForm() {
    $this->drupalGet('admin/config/foo/confirm');
    $this->assertXpath('//h1[text() = "Are you sure you want to delete all examples?"]');
    $this->assertXpath('//form[@id="foo-confirm" and contains(., "This action cannot be undone.")]');
    $this->clickLink('Cancel');
    $this->assertSession()->addressEquals('/admin');

    // Create a table for testing form submission.
    $table['fields']['id']['type'] = 'int';
    Database::getConnection()->schema()->createTable('examples', $table);
    $this->drupalPostForm('admin/config/foo/confirm', [], 'Confirm');
    $this->assertXpath('//div[contains(., "The examples have been deleted.")]');
  }

  /**
   * Checks that an element exists on the current page.
   *
   * @param string $selector
   *   The XPath identifying the element to check.
   */
  protected function assertXpath($selector) {
    $this->assertSession()->elementExists('xpath', $selector);
  }

}
