<?php

namespace Drupal\Tests\plantain\Functional;

use Drupal\Tests\BrowserTestBase;

/**
 * Tests theme settings.
 *
 * @group DCG
 */
final class ThemeSettingsTest extends BrowserTestBase {

  /**
   * {@inheritdoc}
   */
  protected $defaultTheme = 'shreya';

  /**
   * {@inheritdoc}
   */
  protected static $modules = ['plantain'];

  /**
   * Test callback.
   */
  public function testThemeSettings(): void {
    $this->drupalLogin($this->createUser(['administer themes']));
    $this->drupalGet('/admin/appearance/settings/shreya');

    $assert_session = $this->assertSession();
    $assert_session->fieldExists('Font size');
    $assert_session->fieldValueEquals('Font size', 16);
    $this->submitForm(['font_size' => 18], 'Save configuration');
    $assert_session->pageTextContainsOnce('The configuration options have been saved.');
    $assert_session->fieldValueEquals('Font size', 18);

    $saved_font_size = $this->container
      ->get('config.factory')
      ->get('shreya.settings')
      ->get('font_size');
    self::assertSame(18, $saved_font_size);
  }

}
