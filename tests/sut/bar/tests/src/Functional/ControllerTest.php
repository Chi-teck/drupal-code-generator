<?php

declare(strict_types=1);

namespace Drupal\Tests\bar\Functional;

use Drupal\Tests\BrowserTestBase;
use Drupal\dcg_test\TestTrait;
use PHPUnit\Framework\Attributes\Group;

/**
 * Controller test.
 */
#[Group('DCG')]
final class ControllerTest extends BrowserTestBase {

  use TestTrait;

  /**
   * {@inheritdoc}
   */
  protected static $modules = ['bar', 'node'];

  /**
   * {@inheritdoc}
   */
  protected $defaultTheme = 'stark';

  /**
   * Test callback.
   */
  public function testController(): void {
    $user = $this->drupalCreateUser(['access content']);
    $this->drupalLogin($user);
    $this->drupalGet('bar/example');
    $this->assertPageTitle('Example');
    $this->assertSession()->responseMatches('#It works!#s');
  }

}
