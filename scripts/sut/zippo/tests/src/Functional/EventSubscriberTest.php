<?php

namespace Drupal\Tests\zippo\Functional;

use Drupal\Tests\BrowserTestBase;

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
    $xpath = '//li[@class = "messages__item" and text() = "onKernelResponse"]';
    $xpath .= '/following-sibling::li[@class = "messages__item" and text() = "onKernelRequest"]';
    $this->assertSession()->elementExists('xpath', $xpath);
  }

}