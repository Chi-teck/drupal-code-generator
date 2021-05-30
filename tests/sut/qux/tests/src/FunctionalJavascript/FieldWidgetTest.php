<?php

namespace Drupal\Tests\qux\FunctionalJavascript;

/**
 * Tests the field widget.
 *
 * @group DCG
 */
final class FieldWidgetTest extends FieldBaseTest {

  /**
   * Test callback.
   */
  public function testFieldWidget(): void {

    $this->drupalGet('admin/structure/types/manage/test/form-display');

    $assert_session = $this->assertSession();
    $page = $this->getSession()->getPage();

    // Change default widget.
    $page->selectFieldOption('fields[field_wine][type]', 'qux_example');
    $this->waitForAjax();
    $page->pressButton('Save');

    // Check widget summary.
    $xpath = '//tr[@id = "field-wine"]/td/div[@class = "field-plugin-summary" and text() = "Foo: bar"]';
    $assert_session->elementExists('xpath', $xpath);

    // Change widget settings.
    // Some issue in the latest Chrome. Sleep is required to proceed.
    \sleep(1);
    $this->click('#field-wine input[name="field_wine_settings_edit"]');
    $this->waitForAjax();
    $xpath = '//tr[@id = "field-wine"]//input[@name = "fields[field_wine][settings_edit_form][settings][foo]" and @value = "bar"]';
    $assert_session->elementExists('xpath', $xpath);
    $page->fillField('fields[field_wine][settings_edit_form][settings][foo]', 'example');
    $page->pressButton('Update');
    $this->waitForAjax();
    $page->pressButton('Save');

    // Check updated widget summary.
    $xpath = '//tr[@id = "field-wine"]/td/div[@class = "field-plugin-summary" and text() = "Foo: example"]';
    $assert_session->elementExists('xpath', $xpath);

    // Make sure field data is saved correctly.
    $this->drupalGet('node/add/test');
    $edit = [
      'title[0][value]' => 'Test #1',
      'field_wine[0][value]' => 'foo',
    ];
    $this->submitForm($edit, 'Save');
    $xpath = '//div[contains(@class, "field--name-field-wine")]/div[@class="field__item" and text() = "foo"]';
    $assert_session->elementExists('xpath', $xpath);

    // Check default form values.
    $this->drupalGet('node/1/edit');
    $xpath = '//div[contains(@class, "form-item-field-wine-0-value")]/label[text() = "Wine"]/following-sibling::input[@value = "foo"]';
    $assert_session->elementExists('xpath', $xpath);
  }

}
