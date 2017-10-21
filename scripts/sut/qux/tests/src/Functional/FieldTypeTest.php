<?php

namespace Drupal\Tests\qux\Functional;

use TestBase\BrowserTestBase;

/**
 * Test field type.
 *
 * @group DCG
 */
class FieldTypeTest extends BrowserTestBase {

  /**
   * {@inheritdoc}
   */
  public static $modules = ['node', 'field_ui', 'qux'];

  /**
   * Test callback.
   */
  public function testContentPage() {

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
    $edit = [
      'label' => 'Foo',
      'field_name' => 'foo',
      'new_storage_type' => 'example',
    ];
    $this->drupalPostForm('admin/structure/types/manage/test/fields/add-field', $edit, 'Save and continue');

    // Update storage settings.
    $this->xpath('//input[@name = "settings[foo]" and @value = "123"]');
    $edit = [
      'settings[foo]' => 555,
    ];
    $this->drupalPostForm(NULL, $edit, 'Save field settings');

    // Update instance settings.
    $this->xpath('//input[@name = "settings[bar]" and @value = "Bla bla bla"]');
    $edit = [
      'settings[bar]' => 'Yo!',
    ];
    $this->drupalPostForm(NULL, $edit, 'Save settings');

    // Make sure field settings have been persisted correctly.
    $field_settings_url = 'admin/structure/types/manage/test/fields/node.test.field_foo';
    $this->drupalGet($field_settings_url);
    $this->xpath('//input[@name = "settings[bar]" and @value = "Yo!"]');
    $this->drupalGet($field_settings_url . '/storage');
    $this->xpath('//input[@name = "settings[foo]" and @value = "555"]');

    $edit = [
      'title[0][value]' => 'Alpha',
      'field_foo[0][value]' => 'Hello word!',
    ];
    $this->drupalPostForm('node/add/test', $edit, 'Save');
    $this->assertErrorMessage(t('This value is too long. It should have %limit characters or less.', ['%limit' => 10]));

    // Remove exclamation sign to get in the limit.
    $edit = [
      'field_foo[0][value]' => 'Hello word',
    ];
    $this->drupalPostForm(NULL, $edit, 'Save');
    $this->xpath('//div[@class = "field__item" and text() = "Hello word"]');
  }

}
