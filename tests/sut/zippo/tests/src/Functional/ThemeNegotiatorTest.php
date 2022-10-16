<?php declare(strict_types = 1);

namespace Drupal\Tests\zippo\Functional;

use Drupal\Tests\BrowserTestBase;

/**
 * Test theme negotiator.
 *
 * @group DCG
 */
final class ThemeNegotiatorTest extends BrowserTestBase {

  /**
   * {@inheritdoc}
   */
  protected static $modules = ['zippo'];

  /**
   * {@inheritdoc}
   */
  protected $defaultTheme = 'stark';

  /**
   * Test callback.
   */
  public function testThemeNegotiator(): void {
    $this->container->get('theme_installer')->install(['claro']);

    $options = ['query' => ['theme' => 'olivero']];
    $pattern = '#/core/themes/claro/#';
    $assert_session = $this->assertSession();

    $this->drupalGet('<front>', $options);
    $assert_session->responseNotMatches($pattern);

    $this->drupalGet('example', $options);
    $assert_session->responseMatches($pattern);
  }

}
