<?php

declare(strict_types=1);

namespace Drupal\Tests\plantain\Functional;

use Drupal\Tests\BrowserTestBase;
use PHPUnit\Framework\Attributes\Group;

/**
 * Tests theme settings.
 */
#[Group('DCG')]
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
    $assert_session->fieldExists('example');
    $assert_session->fieldValueEquals('example', 'foo');
    $this->submitForm(['example' => 'bar'], 'Save configuration');
    $assert_session->pageTextContainsOnce('The configuration options have been saved.');
    $assert_session->fieldValueEquals('example', 'bar');

    $saved_value = $this->container
      ->get('config.factory')
      ->get('shreya.settings')
      ->get('example');
    self::assertSame('bar', $saved_value);
  }

}
