<?php declare(strict_types = 1);

namespace Drupal\Tests\foo\Functional;

use Drupal\Tests\BrowserTestBase;

/**
 * Test description.
 *
 * @group foo
 */
final class ExampleTest extends BrowserTestBase {

  /**
   * {@inheritdoc}
   */
  protected $defaultTheme = 'claro';

  /**
   * {@inheritdoc}
   */
  protected static $modules = ['foo'];

  /**
   * {@inheritdoc}
   */
  protected function setUp(): void {
    parent::setUp();
    // Set up the test here.
  }

  /**
   * Test callback.
   */
  public function testSomething(): void {
    $admin_user = $this->drupalCreateUser(['access administration pages']);
    $this->drupalLogin($admin_user);
    $this->drupalGet('admin');
    $this->assertSession()->elementExists('xpath', '//h1[text() = "Administration"]');
  }

}
