<?php

namespace Drupal\Tests\bar\Functional;

use TestBase\BrowserTestBase;

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
    $this->assertStatusMessage('Bar subscriber is active.');
    $this->assertStatusMessage('Bar logger is active.');
  }

}
