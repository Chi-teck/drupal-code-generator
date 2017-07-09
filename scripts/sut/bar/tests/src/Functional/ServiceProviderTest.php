<?php

namespace Drupal\Tests\bar\Functional;

use Drupal\Tests\BrowserTestBase;

/**
 * Service provider test.
 *
 * @group DCG
 */
class ServiceProviderTest extends BrowserTestBase {

  /**
   * {@inheritdoc}
   */
  public static $modules = ['bar', 'dblog'];

  /**
   * Test callback.
   */
  public function testProvidedServices() {
    $user = $this->drupalCreateUser();
    $this->drupalLogin($user);
    $this->assertSession()->responseContains('Bar subscriber is active.');
    $this->assertSession()->responseContains('Bar logger is active.');
  }

}
