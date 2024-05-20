<?php

declare(strict_types=1);

namespace Drupal\Tests\zippo\Functional;

use Drupal\Tests\BrowserTestBase;
use PHPUnit\Framework\Attributes\Group;

/**
 * Tests access checker.
 */
#[Group('DCG')]
final class AccessCheckerTest extends BrowserTestBase {

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
  public function testAccessChecker(): void {
    $assert_session = $this->assertSession();

    // The route has a requirement "_zippo: '123'".
    $this->drupalGet('/access-check/123');
    $assert_session->statusCodeEquals(200);

    $this->drupalGet('/access-check/456');
    $assert_session->statusCodeEquals(403);
  }

}
