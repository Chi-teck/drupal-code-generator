<?php

namespace Drupal\Tests\bar\Functional;

use Drupal\dcg_test\TestTrait;
use Drupal\Tests\BrowserTestBase;

/**
 * Service provider test.
 *
 * @group DCG
 */
final class ServiceProviderTest extends BrowserTestBase {

  use TestTrait;

  /**
   * {@inheritdoc}
   */
  public static $modules = ['bar', 'dblog'];

  /**
   * {@inheritdoc}
   */
  protected $defaultTheme = 'stark';

  /**
   * Test callback.
   */
  public function testProvidedServices(): void {
    $user = $this->drupalCreateUser();
    $this->drupalLogin($user);
    $this->assertStatusMessage('Bar subscriber is active.');
    $this->assertStatusMessage('Bar logger is active.');
  }

}
