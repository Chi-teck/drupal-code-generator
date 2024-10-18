<?php

declare(strict_types=1);

namespace Drupal\Tests\zippo\Functional;

use Drupal\Tests\BrowserTestBase;
use Drupal\dcg_test\TestTrait;
use PHPUnit\Framework\Attributes\Group;

/**
 * Event subscriber test.
 */
#[Group('DCG')]
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
