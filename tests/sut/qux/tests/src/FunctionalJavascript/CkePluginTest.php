<?php declare(strict_types = 1);

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
  protected $defaultTheme = 'claro';

  /**
   * {@inheritdoc}
   */
  protected static $modules = ['qux', 'node', 'ckeditor5'];

  /**
   * {@inheritdoc}
   */
  protected function setUp(): void {
    parent::setUp();

    $this->createContentType(['type' => 'test']);

    $permissions = [
      'administer filters',
      'create test content',
      'use text format test',
    ];
    $user = $this->createUser($permissions);
    $this->drupalLogin($user);
  }

  /**
   * Test callback.
   */
  public function testPlugin(): void {
    $this->drupalGet('admin/config/content/formats/manage/test');

    $script = \sprintf(
      'document.getElementById("%s").value = \'%s\'',
      'ckeditor5-toolbar-buttons-selected',
      '["heading","bold","italic","poohBear"]',
    );
    $this->getSession()->executeScript($script);

    $this->submitForm([], 'Save configuration');

    $this->drupalGet('node/add/test');

    $button = $this->xpath('//button[@data-cke-tooltip-text="Pooh Bear"]')[0];

    // SVG cannot be located directly.
    $icon = $button->find('xpath', '/*[local-name() = "svg"]');
    self::assertNotNull($icon);

    $button->click();

    $this->assertSession()->elementExists('xpath', '//div[@role="textbox" and @contenteditable="true"]/p[text() = "It works!"]');

    $this->submitForm(['title[0][value]' => 'Example'], 'Save');
    $this->assertSession()->elementExists('xpath', '//article//p[text() = "It works!"]');
  }

}
