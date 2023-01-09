<?php declare(strict_types = 1);

namespace Drupal\Tests\foo\Functional;

use Drupal\dcg_test\TestTrait;
use Drupal\Tests\BrowserTestBase;

/**
 * Form test.
 *
 * @group DCG
 */
final class FormTest extends BrowserTestBase {

  use TestTrait;

  /**
   * {@inheritdoc}
   */
  protected static $modules = ['foo'];

  /**
   * {@inheritdoc}
   */
  protected $defaultTheme = 'stark';

  /**
   * {@inheritdoc}
   */
  protected function setUp(): void {
    parent::setUp();
    $admin_user = $this->drupalCreateUser(['access administration pages']);
    $this->drupalLogin($admin_user);
  }

  /**
   * Test callback.
   */
  public function testSimpleForm(): void {
    $this->drupalGet('admin/config/foo/simple');
    $prefix = '//form[@id="foo-simple"]';
    $this->assertXpath($prefix . '//label[text() = "Message"]');
    $this->assertXpath($prefix . '//textarea[@name = "message"]');
    $this->assertXpath($prefix . '//input[@type = "submit" and @value = "Send"]');

    $this->submitForm(['message' => 'Hello!'], 'Send');
    $this->assertStatusMessage('The message has been sent.');
    $this->assertSession()->addressEquals('/user/' . $this->container->get('current_user')->id());
  }

  /**
   * Test callback.
   */
  public function testConfigForm(): void {
    $this->drupalGet('admin/config/foo/settings');
    $prefix = '//form[@id="foo-settings"]';
    $this->assertXpath($prefix . '//label[text() = "Example"]');
    $this->assertXpath($prefix . '//input[@name = "example" and @value="none"]');
    $this->assertXpath($prefix . '//input[@type = "submit" and @value = "Save configuration"]');
    $this->submitForm(['example' => 'Some text.'], 'Save configuration');
    $this->assertErrorMessage('The value is not correct.');

    $this->submitForm(['example' => 'example'], 'Save configuration');
    $this->assertStatusMessage('The configuration options have been saved.');
    $this->assertXpath($prefix . '//input[@name = "example" and @value="example"]');
  }

  /**
   * Test callback.
   */
  public function testConfirmForm(): void {
    $this->drupalGet('admin/config/foo/confirm');
    $this->assertPageTitle('Are you sure you want to do this?');
    $this->assertXpath('//form[@id="foo-confirm" and contains(., "This action cannot be undone.")]');
    $this->clickLink('Cancel');
    $this->assertSession()->addressEquals('/admin/config');
    $this->drupalGet('admin/config/foo/confirm');
    $this->submitForm([], 'Confirm');
    $this->assertStatusMessage('Done!');
  }

}
