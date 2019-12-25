<?php

namespace Drupal\Tests\bar\Functional;

use Drupal\dcg_test\TestTrait;
use Drupal\Tests\BrowserTestBase;

/**
 * Controller test.
 *
 * @group DCG
 */
class ControllerTest extends BrowserTestBase {

  use TestTrait;

  /**
   * {@inheritdoc}
   */
  public static $modules = ['bar', 'node'];

  /**
   * {@inheritdoc}
   */
  protected $defaultTheme = 'stark';

  /**
   * Test callback.
   */
  public function testController() {
    $user = $this->drupalCreateUser(['access content']);
    $this->drupalLogin($user);
    $this->drupalGet('bar/example');
    $this->assertPageTitle('Example');
    $this->assertSession()->responseMatches('#It works!#s');
  }

}
