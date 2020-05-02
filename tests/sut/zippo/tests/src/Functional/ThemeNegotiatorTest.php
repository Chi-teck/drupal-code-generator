<?php

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
  public static $modules = ['zippo'];

  /**
   * {@inheritdoc}
   */
  protected $defaultTheme = 'stark';

  /**
   * Test callback.
   */
  public function testThemeNegotiator(): void {
    \Drupal::service('theme_installer')->install(['bartik']);

    $options = ['query' => ['theme' => 'bartik']];
    $pattern = '#/core/themes/bartik/#';
    $assert_session = $this->assertSession();

    $this->drupalGet('<front>', $options);
    $assert_session->responseNotMatches($pattern);

    $this->drupalGet('example', $options);
    $assert_session->responseMatches($pattern);

    $this->drupalGet('example');
    $assert_session->responseNotMatches($pattern);
  }

}
