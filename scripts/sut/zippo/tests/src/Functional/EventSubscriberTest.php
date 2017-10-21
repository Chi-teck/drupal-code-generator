<?php

namespace Drupal\Tests\zippo\Functional;

use TestBase\BrowserTestBase;

/**
 * Event subscriber test.
 *
 * @group DCG
 */
class EventSubscriberTest extends BrowserTestBase {

  /**
   * {@inheritdoc}
   */
  public static $modules = ['zippo'];

  /**
   * Test callback.
   */
  public function testEventSubscriber() {
    $this->drupalGet('<front>');
    $this->assertStatusMessage('onKernelResponse');
    $this->assertStatusMessage('onKernelRequest');
  }

}
