<?php

declare(strict_types=1);

namespace Drupal\Tests\qux\Functional;

use Drupal\Component\Render\FormattableMarkup;
use Drupal\Tests\BrowserTestBase;
use Drupal\dcg_test\TestTrait;
use PHPUnit\Framework\Attributes\Group;

/**
 * Test field type.
 */
#[Group('DCG')]
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
      'new_storage_type' => 'qux_example',
    ];
    $this->submitForm($edit, 'Continue');
    $edit = [
      'label' => 'Foo',
      'field_name' => 'foo',
    ];
    $this->submitForm($edit, 'Continue');
    $this->submitForm([], 'Save settings');

    // Update storage settings.
    $this->drupalGet('/admin/structure/types/manage/test/fields/node.test.field_foo');
    $this->assertXpath('//input[@name = "field_storage[subform][settings][foo]" and @value = ""]');
    $this->assertXpath('//input[@name = "settings[bar]" and @value = ""]');
    $edit = [
      'field_storage[subform][settings][foo]' => 'Hi!',
      'settings[bar]' => 'Yo!',
    ];
    $this->submitForm($edit, 'Save settings');

    // Make sure field settings have been persisted correctly.
    $this->drupalGet('/admin/structure/types/manage/test/fields/node.test.field_foo');
    $this->assertXpath('//input[@name = "settings[bar]" and @value = "Yo!"]');
    $this->assertXpath('//input[@name = "field_storage[subform][settings][foo]" and @value = "Hi!"]');

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
