<?php

namespace Drupal\Tests\zippo\Functional;

use Drupal\dcg_test\TestTrait;
use Drupal\Tests\BrowserTestBase;

/**
 * Event subscriber test.
 *
 * @group DCG
 */
class EventSubscriberTest extends BrowserTestBase {

  use TestTrait;

  /**
   * {@inheritdoc}
   */
  public static $modules = ['zippo'];

  /**
   * {@inheritdoc}
   */
  protected $defaultTheme = 'stark';

  /**
   * Test callback.
   */
  public function testEventSubscriber() {
    $this->drupalGet('<front>');
    $this->assertStatusMessage('onKernelResponse');
    $this->assertStatusMessage('onKernelRequest');
  }

}
