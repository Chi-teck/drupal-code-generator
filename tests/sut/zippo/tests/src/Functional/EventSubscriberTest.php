<?php

declare(strict_types=1);

namespace Drupal\Tests\zippo\Functional;

use Drupal\dcg_test\TestTrait;
use Drupal\Tests\BrowserTestBase;

/**
 * Event subscriber test.
 *
 * @group DCG
 */
final class EventSubscriberTest extends BrowserTestBase {

  use TestTrait;

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
  public function testEventSubscriber(): void {
    $this->drupalGet('<front>');
    $this->assertStatusMessage('onKernelResponse');
    $this->assertStatusMessage('onKernelRequest');
  }

}
