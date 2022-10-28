<?php declare(strict_types = 1);

namespace Drupal\Tests\zippo\Functional;

use Drupal\Tests\BrowserTestBase;

/**
 * Tests param converter.
 *
 * @group DCG
 */
final class ParamConverterTest extends BrowserTestBase {

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
    $assert_session = $this->assertSession();

    $this->drupalGet('/zippo/1');
    $assert_session->statusCodeEquals(200);
    $assert_session->responseContains('alpha');

    $this->drupalGet('/zippo/123');
    $assert_session->statusCodeEquals(404);
    $assert_session->responseNotContains('alpha');
  }

}
