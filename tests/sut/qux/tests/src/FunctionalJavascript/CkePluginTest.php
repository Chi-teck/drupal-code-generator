<?php

namespace Drupal\Tests\qux\FunctionalJavascript;

use Drupal\FunctionalJavascriptTests\WebDriverTestBase;

/**
 * Tests the CKEditor plugin.
 *
 * @group DCG
 */
final class CkePluginTest extends WebDriverTestBase {

  /**
   * {@inheritdoc}
   */
  protected $defaultTheme = 'classy';

  /**
   * {@inheritdoc}
   */
  protected static $modules = ['qux', 'node', 'ckeditor'];

  /**
   * {@inheritdoc}
   */
  protected function setUp(): void {
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
  public function testDialog(): void {
    $this->drupalGet('admin/config/content/formats/manage/test');

    // @codingStandardsIgnoreStart
    // This does not work in the latest Chrome version by some reason.
    // $button = $this->getSession()->getPage()->find('xpath', '//a[@title = "Example"]');
    // $group = $this->getSession()->getPage()->find('xpath', '//li[@data-drupal-ckeditor-toolbar-group-name = "Media"]');
    // $button->dragTo($group);
    // @codingStandardsIgnoreEnd
    $textarea_id = 'edit-editor-settings-toolbar-button-groups';
    $textarea_value = '[[{"name":"Formatting","items":["Bold","Italic"]},{"name":"Linking","items":["DrupalLink","DrupalUnlink"]},{"name":"Lists","items":["BulletedList","NumberedList"]},{"name":"Media","items":["Blockquote","DrupalImage", "example"]},{"name":"Block Formatting","items":["Format"]}]]';
    $script = \sprintf('document.getElementById("%s").value = \'%s\'', $textarea_id, $textarea_value);
    $this->getSession()->executeScript($script);

    $this->submitForm([], 'Save configuration');

    $this->drupalGet('node/add/test');

    $button = $this->xpath('//a[contains(@class, "cke_button__example") and @title = "Insert abbreviation"]')[0];
    $icon = $button->find('xpath', '//span[contains(@class, cke_button_icon)]');
    self::assertStringContainsString('/modules/qux/js/plugins/example/icons/example.png', $icon->getAttribute('style'));

    $button->click();

    $dialog = $this->assertSession()->waitForElementVisible('xpath', '//div[contains(@class, "cke_editor_edit-body-0-value_dialog")]');
    self::assertNotNull($dialog);
    $title = $dialog->find('xpath', '//div[@class = "cke_dialog_title"]');
    self::assertSame('Abbreviation properties', $title->getHtml());

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
