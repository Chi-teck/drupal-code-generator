<?php

declare(strict_types=1);

namespace Drupal\Tests\zippo\Functional;

use Drupal\Tests\BrowserTestBase;
use PHPUnit\Framework\Attributes\Group;

/**
 * Test theme negotiator.
 */
#[Group('DCG')]
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

    $pattern = '#/core/themes/claro/#';
    $assert_session = $this->assertSession();

    $this->drupalGet('<front>');
    $assert_session->responseNotMatches($pattern);

    $this->drupalGet('example');
    $assert_session->responseMatches($pattern);
  }

}
