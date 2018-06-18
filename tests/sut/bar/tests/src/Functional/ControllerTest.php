<?php

namespace Drupal\Tests\bar\Functional;

use TestBase\BrowserTestBase;

/**
 * Controller test.
 *
 * @group DCG
 */
class ControllerTest extends BrowserTestBase {

  /**
   * {@inheritdoc}
   */
  public static $modules = ['bar', 'node'];

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
