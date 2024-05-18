<?php

declare(strict_types=1);

namespace Drupal\Tests\qux\FunctionalJavascript;

/**
 * Tests the field formatter.
 *
 * @group DCG
 */
final class FieldFormatter extends FieldBase {

  /**
   * Test callback.
   */
  public function testFieldFormatter(): void {

    $this->drupalGet('admin/structure/types/manage/test/display');

    $assert_session = $this->assertSession();
    $page = $this->getSession()->getPage();

    // Change default formatter.
    $page->selectFieldOption('fields[field_wine][type]', 'qux_example');
    $this->waitForAjax();
    $page->pressButton('Save');

    // Change formatter settings.
    $this->click('#field-wine input[name="field_wine_settings_edit"]');
    $this->waitForAjax();
    // Some issue in the latest Chrome. Sleep is required to proceed.
    \sleep(1);
    $xpath = '//tr[@id = "field-wine"]//input[@name = "fields[field_wine][settings_edit_form][settings][foo]" and @value = "bar"]';
    $assert_session->elementExists('xpath', $xpath);
    $page->fillField('fields[field_wine][settings_edit_form][settings][foo]', 'example');
    $page->pressButton('Update');
    $this->waitForAjax();
    $page->pressButton('Save');

    // Check formatter summary.
    $xpath = '//tr[@id = "field-wine"]/td/div[@class = "field-plugin-summary" and text() = "Foo: example"]';
    $assert_session->elementExists('xpath', $xpath);

    // Make sure field data is displayed correctly.
    $this->drupalGet('node/add/test');
    $edit = [
      'title[0][value]' => 'Test #1',
      'field_wine[0][value]' => 'foo',
    ];
    $this->submitForm($edit, 'Save');
    $xpath = '//div[contains(@class, "field--name-field-wine")]/div[@class="field__item" and normalize-space(text()) = "foo"]';
    $assert_session->elementExists('xpath', $xpath);
  }

}
