<?php declare(strict_types = 1);

namespace Drupal\Tests\tandoor\Functional;

use Drupal\Tests\BrowserTestBase;

/**
 * Tests generated theme.
 *
 * @group DCG
 */
final class ThemeTest extends BrowserTestBase {

  /**
   * {@inheritdoc}
   */
  protected $defaultTheme = 'azalea';

  /**
   * Test callback.
   */
  public function testCssFiles(): void {
    $this->drupalGet('/user');
    $this->assertCssFile('base/elements.css');
    $this->assertCssFile('layouts/layout.css');
    $this->assertCssFile('components/buttons.css');
    $this->assertCssFile('components/block.css');
    $this->assertCssFile('components/breadcrumb.css');
    $this->assertCssFile('components/field.css');
    $this->assertCssFile('components/form.css');
    $this->assertCssFile('components/header.css');
    $this->assertCssFile('components/menu.css');
    $this->assertCssFile('components/messages.css');
    $this->assertCssFile('components/node.css');
    $this->assertCssFile('components/sidebar.css');
    $this->assertCssFile('components/table.css');
    $this->assertCssFile('components/tabs.css');
    $this->assertCssFile('components/buttons.css');
    $this->assertCssFile('theme/print.css');

    // Make sure CSS files from base theme are loaded.
    $this->assertSession()->elementExists('xpath', '//link[contains(@href, "/core/themes/bartik/css/components/buttons.css?")]');
  }

  /**
   * Test callback.
   */
  public function testThemeSettings(): void {
    $this->drupalLogin($this->createUser(['administer themes']));
    $this->drupalGet('/admin/appearance/settings/azalea');

    $assert_session = $this->assertSession();
    $assert_session->fieldExists('example');
    $assert_session->fieldValueEquals('example', 'foo');
    $this->submitForm(['example' => 'bar'], 'Save configuration');
    $assert_session->pageTextContainsOnce('The configuration options have been saved.');
    $assert_session->fieldValueEquals('example', 'bar');

    $saved_value = $this->container
      ->get('config.factory')
      ->get('azalea.settings')
      ->get('example');
    self::assertSame('bar', $saved_value);
  }

  /**
   * Asserts theme CSS file.
   */
  private function assertCssFile(string $path): void {
    $full_path = '/themes/azalea/css/' . $path;
    $this->assertSession()->elementExists(
      'xpath',
      \sprintf('//link[contains(@href, "%s?")]', $full_path),
    );
    self::assertFileExists(self::getDrupalRoot() . $full_path);
  }

}
