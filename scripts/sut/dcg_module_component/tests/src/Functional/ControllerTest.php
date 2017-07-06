<?php

namespace Drupal\Tests\dcg_module_component\Functional;

use Drupal\Tests\BrowserTestBase;

/**
 * Controller test.
 *
 * @group DCG
 */
class ControllerTest extends BrowserTestBase {

  /**
   * {@inheritdoc}
   */
  public static $modules = ['dcg_module_component', 'node'];

  /**
   * Test callback.
   */
  public function testController() {
    $user = $this->drupalCreateUser(['access content']);
    $this->drupalLogin($user);

    $this->drupalGet('foo/example');

    $this->assertXpath('//h1[@class = "page-title" and text() = "Example"]');
    $this->assertSession()->responseMatches('#<label>Content</label>\s*Hello world!#s');
    $this->assertSession()->responseMatches('#<label>Date</label>\s*[A-z]+, [0-9]{2}/[0-9]{2}/[0-9]{4} - [0-9]{2}:[0-9]{2}#s');
  }

  /**
   * Checks that an element exists on the current page.
   *
   * @param string $selector
   *   The XPath identifying the element to check.
   */
  protected function assertXpath($selector) {
    $this->assertSession()->elementExists('xpath', $selector);
  }

}
