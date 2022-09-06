<?php declare(strict_types = 1);

namespace Drupal\Tests\yety\Functional;

use Drupal\Tests\BrowserTestBase;

/**
 * Routing test.
 *
 * @group DCG
 */
final class RoutingTest extends BrowserTestBase {

  /**
   * {@inheritdoc}
   */
  protected static $modules = ['yety'];

  /**
   * {@inheritdoc}
   */
  protected $defaultTheme = 'stark';

  /**
   * Test callback.
   */
  public function testRoute(): void {
    $this->drupalGet('yety/example');
    // The request returns 'Access denied' because the generated route defines
    // non-existing permission.
    $this->assertSession()->statusCodeEquals(403);
  }

}
