<?php

namespace Drupal\Tests\qux\Functional;

use Drupal\Component\Render\FormattableMarkup;
use Drupal\dcg_test\TestTrait;
use Drupal\Tests\BrowserTestBase;

/**
 * Test field type.
 *
 * @group DCG
 */
final class FieldTypeTest extends BrowserTestBase {

  use TestTrait;

  /**
   * {@inheritdoc}
   */
  protected static $modules = ['qux', 'node', 'field_ui'];

  /**
   * {@inheritdoc}
   */
  protected $defaultTheme = 'stark';

  /**
   * Test callback.
   */
  public function testFieldType(): void {

    $this->drupalCreateContentType(['type' => 'test']);

    $permissions = [
      'administer site configuration',
      'administer nodes',
      'create test content',
      'administer content types',
      'administer node fields',
    ];
    $admin_user = $this->drupalCreateUser($permissions);
    $this->drupalLogin($admin_user);

    // Create new field.
    $this->drupalGet('admin/structure/types/manage/test/fields/add-field');
    $edit = [
      'label' => 'Foo',
      'field_name' => 'foo',
      'new_storage_type' => 'qux_example',
    ];
    $this->submitForm($edit, 'Save and continue');

    // Update storage settings.
    $this->assertXpath('//input[@name = "settings[foo]" and @value = "wine"]');
    $edit = [
      'settings[foo]' => 'Hi!',
    ];
    $this->submitForm($edit, 'Save field settings');

    // Update instance settings.
    $this->assertXpath('//input[@name = "settings[bar]" and @value = "beer"]');
    $edit = [
      'settings[bar]' => 'Yo!',
    ];
    $this->submitForm($edit, 'Save settings');

    // Make sure field settings have been persisted correctly.
    $field_settings_url = 'admin/structure/types/manage/test/fields/node.test.field_foo';
    $this->drupalGet($field_settings_url);
    $this->assertXpath('//input[@name = "settings[bar]" and @value = "Yo!"]');
    $this->drupalGet($field_settings_url . '/storage');
    $this->assertXpath('//input[@name = "settings[foo]" and @value = "Hi!"]');

    // Check the field length constraint.
    $this->drupalGet('node/add/test');
    $edit = [
      'title[0][value]' => 'Alpha',
      'field_foo[0][value]' => 'Hello word!',
    ];
    $this->submitForm($edit, 'Save');
    $this->assertErrorMessage(new FormattableMarkup('This value is too long. It should have %limit characters or less.', ['%limit' => 10]));

    // Remove the exclamation sign to get in the limit.
    $edit = [
      'field_foo[0][value]' => 'Hello word',
    ];
    $this->submitForm($edit, 'Save');
    $this->assertXpath('//div[text() = "Foo"]/following-sibling::div[text() = "Hello word"]');
  }

}
