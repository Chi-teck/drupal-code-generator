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
    $this->assertCssFile('layout/layout.css');
    $this->assertCssFile('component/buttons.css');
    $this->assertCssFile('component/block.css');
    $this->assertCssFile('component/breadcrumb.css');
    $this->assertCssFile('component/field.css');
    $this->assertCssFile('component/form.css');
    $this->assertCssFile('component/header.css');
    $this->assertCssFile('component/menu.css');
    $this->assertCssFile('component/messages.css');
    $this->assertCssFile('component/node.css');
    $this->assertCssFile('component/sidebar.css');
    $this->assertCssFile('component/table.css');
    $this->assertCssFile('component/tabs.css');
    $this->assertCssFile('component/buttons.css');
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
