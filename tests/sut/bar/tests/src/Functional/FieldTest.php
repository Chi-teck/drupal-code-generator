<?php declare(strict_types = 1);

namespace Drupal\Tests\bar\Functional;

use Drupal\Component\Render\FormattableMarkup as FM;
use Drupal\Core\Datetime\DrupalDateTime;
use Drupal\dcg_test\TestTrait;
use Drupal\Tests\BrowserTestBase;
use Drupal\Tests\node\Traits\NodeCreationTrait;

/**
 * Field test.
 *
 * @group DCG
 */
final class FieldTest extends BrowserTestBase {

  use NodeCreationTrait;
  use TestTrait;

  /**
   * {@inheritdoc}
   */
  protected static $modules = ['bar', 'node', 'field_ui'];

  /**
   * {@inheritdoc}
   */
  protected $defaultTheme = 'stark';

  /**
   * {@inheritdoc}
   */
  protected function setUp(): void {
    parent::setUp();
    $this->createContentType(['type' => 'page', 'name' => 'Page']);
    $permissions = [
      'administer node fields',
      'create page content',
      'edit own page content',
      'administer node form display',
      'administer node display',
    ];
    $admin_user = $this->drupalCreateUser($permissions);
    $this->drupalLogin($admin_user);
  }

  /**
   * Test callback.
   */
  public function testFieldExample1(): void {
    $this->drupalGet('admin/structure/types/manage/page/fields/add-field');
    $edit = [
      'new_storage_type' => 'bar_example_1',
      'label' => 'Foo',
      'field_name' => 'foo',
    ];
    $this->submitForm($edit, 'Save and continue');
    $this->submitForm([], 'Save field settings');
    $this->submitForm([], 'Save settings');
    $this->assertStatusMessage(new FM('Saved %label configuration.', ['%label' => 'Foo']));

    // -- Test widget form elements.
    $this->drupalGet('node/add/page');
    $prefix = '//div[contains(@class, "field--name-field-foo")]/div/div[contains(@class, "bar-example-1-elements")]/div';
    $this->assertXpath($prefix . '/input[@type = "checkbox" and @name = "field_foo[0][value_1]"]/following::label[text() = "Value 1"][1]');
    $this->assertXpath($prefix . '/label[text() = "Value 2"]/following::input[@type = "text" and @name = "field_foo[0][value_2]"][1]');
    $this->assertXpath($prefix . '/label[text() = "Value 3"]/following::div/textarea[@name = "field_foo[0][value_3]"][1]');
    $this->assertXpath($prefix . '/label[text() = "Value 4"]/following::input[@type = "number" and @name = "field_foo[0][value_4]" and @step = 1][1]');
    $this->assertXpath($prefix . '/label[text() = "Value 5"]/following::input[@type = "number" and @name = "field_foo[0][value_5]" and @step = 0.001][1]');
    $this->assertXpath($prefix . '/label[text() = "Value 6"]/following::input[@type = "number" and @name = "field_foo[0][value_6]" and @step = 0.01][1]');
    $this->assertXpath($prefix . '/label[text() = "Value 7"]/following::input[@type = "email" and @name = "field_foo[0][value_7]"][1]');
    $this->assertXpath($prefix . '/label[text() = "Value 8"]/following::input[@type = "tel" and @name = "field_foo[0][value_8]"][1]');
    $this->assertXpath($prefix . '/label[text() = "Value 9"]/following::input[@type = "url" and @name = "field_foo[0][value_9]"][1]');
    $this->assertXpath($prefix . '/div/label[text() = "Date"]/following::input[@type = "date" and @name = "field_foo[0][value_10][date]"][1]');

    $edit = [
      'title[0][value]' => 'Test',
      'field_foo[0][value_1]' => TRUE,
    ];
    $this->submitForm($edit, 'Save');
    // Make sure that none of the other fields are required.
    $this->assertSession()->pageTextContains('Page Test has been created.');

    // Test validation.
    $this->drupalGet('node/1/edit');
    $edit = [
      'title[0][value]' => 'Test',
      'field_foo[0][value_1]' => TRUE,
      'field_foo[0][value_2]' => \str_repeat('x', 129),
      'field_foo[0][value_3]' => 'value_3_content',
      'field_foo[0][value_4]' => 'wrong integer',
      'field_foo[0][value_5]' => 'wrong float',
      'field_foo[0][value_6]' => 'wrong decimal',
      'field_foo[0][value_7]' => 'wrong email',
      'field_foo[0][value_8]' => \str_repeat('x', 129),
      'field_foo[0][value_9]' => 'wrong URL',
      'field_foo[0][value_10][date]' => 'wrong date',
    ];
    $this->submitForm($edit, 'Save');

    $arguments = [
      '@label' => 'Value 2',
      '%limit' => '128',
      '%value' => '129',
    ];
    $message = new FM('@label cannot be longer than %limit characters but is currently %value characters long.', $arguments);
    $this->assertErrorMessage($message);

    $message = new FM('%label must be a number.', ['%label' => 'Value 4']);
    $this->assertErrorMessage($message);

    $message = new FM('%label must be a number.', ['%label' => 'Value 5']);
    $this->assertErrorMessage($message);

    $message = new FM('%label must be a number.', ['%label' => 'Value 6']);
    $this->assertErrorMessage($message);

    $message = new FM('The email address %value is not valid.', ['%value' => 'wrong email']);
    $this->assertErrorMessage($message);

    $arguments = [
      '@label' => 'Value 8',
      '%limit' => '128',
      '%value' => '129',
    ];
    $message = new FM('@label cannot be longer than %limit characters but is currently %value characters long.', $arguments);
    $this->assertErrorMessage($message);

    $message = new FM('The URL %value is not valid.', ['%value' => 'wrong URL']);
    $this->assertErrorMessage($message);

    $arguments = [
      '%label' => 'Value 10',
      '%format' => (new DrupalDateTime())->format('Y-m-d'),
    ];
    $message = new FM('The %label date is invalid. Please enter a date in the format %format.', $arguments);
    $this->assertErrorMessage($message);

    // Submit the form with correct values and test formatter output.
    $this->drupalGet('node/1/edit');
    $edit = [
      'title[0][value]' => 'Test',
      'field_foo[0][value_1]' => FALSE,
      'field_foo[0][value_2]' => 'value_2_content',
      'field_foo[0][value_3]' => 'value_3_content',
      'field_foo[0][value_4]' => 123,
      'field_foo[0][value_5]' => 123.456,
      'field_foo[0][value_6]' => 123.45,
      'field_foo[0][value_7]' => 'no-reply@example.com',
      'field_foo[0][value_8]' => '89124578945',
      'field_foo[0][value_9]' => 'https://example.com',
      'field_foo[0][value_10][date]' => '2018-08-06',
    ];
    $this->submitForm($edit, 'Save');
    $this->assertSession()->pageTextContains('Page Test has been updated.');

    $this->assertXpath('//label[text() = "Value 1" and normalize-space(following::text()[1]) = "No"]');
    $this->assertXpath('//label[text() = "Value 2" and normalize-space(following::text()[1]) = "value_2_content"]');
    $this->assertXpath('//label[text() = "Value 3" and normalize-space(following::text()[1]) = "value_3_content"]');
    $this->assertXpath('//label[text() = "Value 4" and normalize-space(following::text()[1]) = "123"]');
    $this->assertXpath('//label[text() = "Value 5" and normalize-space(following::text()[1]) = "123.456"]');
    $this->assertXpath('//label[text() = "Value 6" and normalize-space(following::text()[1]) = "123.45"]');
    $this->assertXpath('//label[text() = "Value 7"]/following::a[@href = "mailto:no-reply@example.com" and text() = "no-reply@example.com"][1]');
    $this->assertXpath('//label[text() = "Value 8"]/following::a[@href = "tel:89124578945" and text() = "89124578945"][1]');
    $this->assertXpath('//label[text() = "Value 9"]/following::a[@href = "https://example.com" and text() = "https://example.com"][1]');
    $this->assertXpath('//label[text() = "Value 10"]/following::time[@datetime][1]');
  }

  /**
   * Test callback.
   */
  public function testFieldExample2(): void {
    $this->drupalGet('admin/structure/types/manage/page/fields/add-field');
    $edit = [
      'new_storage_type' => 'bar_example_2',
      'label' => 'Foo',
      'field_name' => 'foo',
    ];
    $this->submitForm($edit, 'Save and continue');
    $this->submitForm([], 'Save field settings');
    $this->submitForm([], 'Save settings');
    $this->assertStatusMessage(new FM('Saved %label configuration.', ['%label' => 'Foo']));

    // -- Test widget form elements.
    $this->drupalGet('node/add/page');
    $prefix = '//div[contains(@class, "field--name-field-foo")]/div/div[contains(@class, "bar-example-2-elements")]/div';

    $this->assertXpath($prefix . '/input[@type = "checkbox" and @name = "field_foo[0][value_1]"]/following::label[text() = "Value 1"][1]');

    $xpath = '/label[text() = "Value 2"]/following::select[@name = "field_foo[0][value_2]"]';
    $options = [
      '- Select a value -',
      'Alpha',
      'Beta',
      'Gamma',
    ];
    $this->assertXpath($prefix . $xpath . self::buildOptionsXpath($options, 0));

    $this->assertXpath($prefix . '/label[text() = "Value 3"]/following::div/textarea[@name = "field_foo[0][value_3]"]');

    $xpath = '/label[text() = "Value 4"]/following::select[@name = "field_foo[0][value_4]"]';
    $options = [
      '- None -',
      '123',
      '456',
      '789',
    ];
    $this->assertXpath($prefix . $xpath . self::buildOptionsXpath($options, 0));

    $xpath = '/label[text() = "Value 5"]/following::select[@name = "field_foo[0][value_5]"]';
    $options = [
      '- Select a value -',
      '12.3',
      '4.56',
      '0.789',
    ];
    $this->assertXpath($prefix . $xpath . self::buildOptionsXpath($options, 0));

    $xpath = '/label[text() = "Value 6"]/following::select[@name = "field_foo[0][value_6]"]';
    $options = [
      '- None -',
      '12.35',
      '45.65',
      '78.95',
    ];
    $this->assertXpath($prefix . $xpath . self::buildOptionsXpath($options, 0));

    $xpath = '/label[text() = "Value 7"]/following::select[@name = "field_foo[0][value_7]"]';
    $options = [
      '- Select a value -',
      'alpha@example.com',
      'beta@example.com',
      'gamma@example.com',
    ];
    $this->assertXpath($prefix . $xpath . self::buildOptionsXpath($options, 0));

    $xpath = '/label[text() = "Value 8"]/following::select[@name = "field_foo[0][value_8]"]';
    $options = [
      '- None -',
      '+7(123)45-67-001',
      '+7(123)45-67-002',
      '+7(123)45-67-003',
    ];
    $this->assertXpath($prefix . $xpath . self::buildOptionsXpath($options, 0));

    $xpath = '/label[text() = "Value 9"]/following::select[@name = "field_foo[0][value_9]"]';
    $options = [
      '- Select a value -',
      'https://example.com',
      'https://www.php.net',
      'https://www.drupal.org',
    ];
    $this->assertXpath($prefix . $xpath . self::buildOptionsXpath($options, 0));

    $xpath = '/label[text() = "Value 10"]/following::select[@name = "field_foo[0][value_10]"]';
    $options = [
      '- None -',
      '1 January 2018, 00:10:10',
      '1 February 2018, 00:20:20',
      '1 March 2018, 00:30:30',
    ];
    $this->assertXpath($prefix . $xpath . self::buildOptionsXpath($options, 0));

    // Test validation.
    $edit = [
      'title[0][value]' => 'Test',
    ];
    $this->submitForm($edit, 'Save');
    // Make sure that all fields pass validation.
    $this->assertSession()->pageTextContains('Page Test has been created.');

    $this->drupalGet('node/1/edit');
    $edit = [
      'title[0][value]' => 'Test',
      'field_foo[0][value_4]' => '123',
    ];
    $this->submitForm($edit, 'Save');

    $this->assertErrorMessage('This value should not be blank.');

    $this->assertXpath($prefix . '/input[@name = "field_foo[0][value_1]" and contains(@class, "error")]');
    $this->assertXpath($prefix . '/select[@name = "field_foo[0][value_2]" and contains(@class, "error")]');
    $this->assertXpath($prefix . '/div/textarea[@name = "field_foo[0][value_3]" and contains(@class, "error")]');
    $this->assertXpath($prefix . '/select[@name = "field_foo[0][value_4]" and not(contains(@class, "error"))]');
    $this->assertXpath($prefix . '/select[@name = "field_foo[0][value_5]" and contains(@class, "error")]');
    $this->assertXpath($prefix . '/select[@name = "field_foo[0][value_6]" and not(contains(@class, "error"))]');
    $this->assertXpath($prefix . '/select[@name = "field_foo[0][value_7]" and contains(@class, "error")]');
    $this->assertXpath($prefix . '/select[@name = "field_foo[0][value_8]" and not(contains(@class, "error"))]');
    $this->assertXpath($prefix . '/select[@name = "field_foo[0][value_9]" and contains(@class, "error")]');
    $this->assertXpath($prefix . '/select[@name = "field_foo[0][value_10]" and not(contains(@class, "error"))]');

    // Submit the form with correct values and test formatter output.
    $this->drupalGet('node/1/edit');
    $edit = [
      'title[0][value]' => 'Test',
      'field_foo[0][value_1]' => TRUE,
      'field_foo[0][value_2]' => 'alpha',
      'field_foo[0][value_3]' => 'value_3_content',
      'field_foo[0][value_4]' => '123',
      'field_foo[0][value_5]' => '12.3',
      'field_foo[0][value_6]' => '12.35',
      'field_foo[0][value_7]' => 'alpha@example.com',
      'field_foo[0][value_8]' => '71234567001',
      'field_foo[0][value_9]' => 'https://example.com',
      'field_foo[0][value_10]' => '2018-01-01T00:10:10',
    ];
    $this->submitForm($edit, 'Save');
    $this->assertSession()->pageTextContains('Page Test has been updated.');

    $this->assertXpath('//label[text() = "Value 1" and normalize-space(following::text()[1]) = "Yes"]');
    $this->assertXpath('//label[text() = "Value 2" and normalize-space(following::text()[1]) = "Alpha"]');
    $this->assertXpath('//label[text() = "Value 3" and normalize-space(following::text()[1]) = "value_3_content"]');
    $this->assertXpath('//label[text() = "Value 4" and normalize-space(following::text()[1]) = "123"]');
    $this->assertXpath('//label[text() = "Value 5" and normalize-space(following::text()[1]) = "12.3"]');
    $this->assertXpath('//label[text() = "Value 6" and normalize-space(following::text()[1]) = "12.35"]');
    $this->assertXpath('//label[text() = "Value 7"]/following::a[@href = "mailto:alpha@example.com" and text() = "alpha@example.com"][1]');
    $this->assertXpath('//label[text() = "Value 8"]/following::a[@href = "tel:71234567001" and text() = "+7(123)45-67-001"][1]');
    $this->assertXpath('//label[text() = "Value 9"]/following::a[@href = "https://example.com" and text() = "https://example.com"][1]');
    $this->assertXpath('//label[text() = "Value 10"]/following::time[@datetime = "2018-01-01T00:10:10Z" and text() = "1 January 2018, 00:10:10"][1]');
  }

  /**
   * Test callback.
   */
  public function testFieldExample3(): void {
    $this->drupalGet('admin/structure/types/manage/page/fields/add-field');
    $edit = [
      'new_storage_type' => 'bar_example_3',
      'label' => 'Foo',
      'field_name' => 'foo',
    ];
    $this->submitForm($edit, 'Save and continue');

    $this->assertXpath('//label[text() = "Foo"]/following::input[@name = "settings[foo]" and @value = "example"][1]');
    $edit = [
      'settings[foo]' => 'test 1',
    ];
    $this->submitForm($edit, 'Save field settings');

    $this->assertXpath('//label[text() = "Bar"]/following::input[@name = "settings[bar]" and @value = "example"][1]');
    $edit = [
      'settings[bar]' => 'test 2',
    ];
    $this->submitForm($edit, 'Save settings');

    $this->assertStatusMessage(new FM('Saved %label configuration.', ['%label' => 'Foo']));

    // Make sure the settings are saved.
    $this->drupalGet('admin/structure/types/manage/page/fields/node.page.field_foo/storage');
    $this->assertXpath('//label[text() = "Foo"]/following::input[@name = "settings[foo]" and @value = "test 1"][1]');
    $this->drupalGet('admin/structure/types/manage/page/fields/node.page.field_foo');
    $this->assertXpath('//label[text() = "Bar"]/following::input[@name = "settings[bar]" and @value = "test 2"][1]');

    $this->drupalGet('admin/structure/types/manage/page/form-display');
    $this->assertXpath('//tr[@id = "field-foo"]/td/div[text() = "Foo: bar"]');

    $this->drupalGet('admin/structure/types/manage/page/display');
    $this->assertXpath('//tr[@id = "field-foo"]/td/div[text() = "Foo: bar"]');

    $this->drupalGet('node/add/page');
    $edit = [
      'title[0][value]' => 'Test',
      'field_foo[0][value_1]' => TRUE,
      'field_foo[0][value_2]' => 'value_2_content',
      'field_foo[0][value_3]' => '123.456',
      'field_foo[0][value_4]' => 'beta@example.com',
      'field_foo[0][value_5]' => 'https://www.drupal.org',
    ];
    $this->submitForm($edit, 'Save');
    $this->assertSession()->pageTextContains('Page Test has been created.');

    // Default formatter.
    $this->assertXpath('//label[text() = "Value 1" and normalize-space(following::text()[1]) = "Yes"]');
    $this->assertXpath('//label[text() = "Value 2" and normalize-space(following::text()[1]) = "value_2_content"]');
    $this->assertXpath('//label[text() = "Value 3" and normalize-space(following::text()[1]) = "123.456"]');
    $this->assertXpath('//label[text() = "Value 4"]/following::a[@href = "mailto:beta@example.com" and text() = "beta@example.com"][1]');
    $this->assertXpath('//label[text() = "Value 5"]/following::a[@href = "https://www.drupal.org" and text() = "https://www.drupal.org"][1]');

    // Key-value formatter.
    $this->drupalGet('admin/structure/types/manage/page/display');
    $edit = [
      'fields[field_foo][type]' => 'bar_example_3_key_value',
    ];
    $this->submitForm($edit, 'Save');
    $this->drupalGet('node/1');

    $this->assertXpath('//table/tbody/tr/th[text() = "Value 1"]/following::td[text() = "Yes"]');
    $this->assertXpath('//table/tbody/tr/th[text() = "Value 2"]/following::td[text() = "value_2_content"]');
    $this->assertXpath('//table/tbody/tr/th[text() = "Value 4"]/following::td[text() = "beta@example.com"]');
    $this->assertXpath('//table/tbody/tr/th[text() = "Value 5"]/following::td[text() = "https://www.drupal.org"]');

    // Table formatter.
    $this->drupalGet('admin/structure/types/manage/page/display');
    $edit = [
      'fields[field_foo][type]' => 'bar_example_3_table',
    ];
    $this->submitForm($edit, 'Save');
    $this->drupalGet('node/1');
    $xpath = '//table/thead/tr/th[text() = "#"]';
    $xpath .= '/following::th[text() = "Value 1"][1]';
    $xpath .= '/following::th[text() = "Value 2"][1]';
    $xpath .= '/following::th[text() = "Value 3"][1]';
    $xpath .= '/following::th[text() = "Value 4"][1]';
    $xpath .= '/following::th[text() = "Value 5"][1]';
    $this->assertXpath($xpath);
    $xpath = '//table/tbody/tr/td[text() = "1"]';
    $xpath .= '/following::td[text() = "Yes"][1]';
    $xpath .= '/following::td[text() = "value_2_content"][1]';
    $xpath .= '/following::td[text() = "123.456"][1]';
    $xpath .= '/following::td[text() = "beta@example.com"][1]';
    $xpath .= '/following::td[text() = "https://www.drupal.org"][1]';
    $this->assertXpath($xpath);
  }

  /**
   * Builds options xpath.
   */
  private static function buildOptionsXpath(array $options, int $selected_option): string {
    $xpath = \sprintf('/option[text() = "%s"%s]', \array_shift($options), $selected_option == 0 ? ' and @selected' : '');
    foreach ($options as $index => $option) {
      $xpath .= \sprintf('/following::option[text() = "%s"%s][1]', $option, $selected_option == $index + 1 ? ' and @selected' : '');
    }
    return $xpath;
  }

}
