<?php

namespace Drupal\Tests\qux\FunctionalJavascript;

use Drupal\FunctionalJavascriptTests\WebDriverTestBase;

/**
 * Tests the CKEditor plugin.
 *
 * @group DCG
 */
class CkePluginTest extends WebDriverTestBase {

  /**
   * {@inheritdoc}
   */
  public static $modules = ['qux', 'node', 'ckeditor'];

  /**
   * {@inheritdoc}
   */
  protected function setUp() {
    parent::setUp();

    $this->createContentType(['type' => 'test']);

    $permissions = [
      'administer filters',
      'create test content',
    ];
    $user = $this->createUser($permissions);
    $this->drupalLogin($user);
  }

  /**
   * Test callback.
   */
  public function testDialog() {
    $this->drupalGet('admin/config/content/formats/manage/test');

    $button = $this->getSession()->getPage()->find('xpath', '//a[@title = "Example"]');
    $group = $this->getSession()->getPage()->find('xpath', '//li[@data-drupal-ckeditor-toolbar-group-name = "Media"]');
    $button->dragTo($group);
    $this->submitForm([], 'Save configuration');

    $this->drupalGet('node/add/test');

    $button = $this->xpath('//a[contains(@class, "cke_button__example") and @title = "Insert abbreviation"]')[0];
    $icon = $button->find('xpath', '//span[contains(@class, cke_button_icon)]');
    self::assertContains('/modules/qux/js/plugins/example/icons/example.png', $icon->getAttribute('style'));

    $button->click();

    $dialog = $this->assertSession()->waitForElementVisible('xpath', '//div[contains(@class, "cke_editor_edit-body-0-value_dialog")]');
    self::assertNotNull($dialog);
    $title = $dialog->find('xpath', '//div[@class = "cke_dialog_title"]');
    self::assertEquals('Abbreviation properties', $title->getHtml());

    $dialog->fillField('Abbreviation', 'foo');
    $dialog->fillField('Explanation', 'bar');
    $dialog->pressButton('OK');

    $edit = [
      'title[0][value]' => 'Example',
    ];
    $this->submitForm($edit, 'Save');

    $this->assertSession()->elementExists('xpath', '//abbr[@title = "bar" and text() = "foo"]');
  }

}
