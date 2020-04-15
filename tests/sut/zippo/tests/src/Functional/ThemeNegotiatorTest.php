<?php

namespace Drupal\Tests\zippo\Functional;

use Drupal\Tests\BrowserTestBase;

/**
 * Test theme negotiator.
 *
 * @group DCG
 */
class ThemeNegotiatorTest extends BrowserTestBase {

  /**
   * {@inheritdoc}
   */
  protected $defaultTheme = 'stark';

  /**
   * {@inheritdoc}
   */
  public static $modules = ['zippo'];

  /**
   * Test callback.
   */
  public function testThemeNegotiator() {
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
