<?php

namespace Drupal\Tests\foo\FunctionalJavascript;

use Drupal\FunctionalJavascriptTests\WebDriverTestBase;

/**
 * Tests the JavaScript functionality of the Foo module.
 *
 * @group foo
 */
class ExampleTest extends WebDriverTestBase {

  /**
   * {@inheritdoc}
   */
  protected $defaultTheme = 'stable';

  /**
   * {@inheritdoc}
   */
  public static $modules = ['foo'];

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
  public function testSomething() {
    // Let's test password strength widget.
    \Drupal::configFactory()->getEditable('user.settings')
      ->set('verify_mail', FALSE)
      ->save();

    $this->drupalGet('user/register');

    $page = $this->getSession()->getPage();

    $password_field = $page->findField('Password');
    $password_strength = $page->find('css', '.js-password-strength__text');

    self::assertSame('', $password_strength->getText());

    $password_field->setValue('abc');
    self::assertSame('Weak', $password_strength->getText());

    $password_field->setValue('abcABC123!');
    self::assertSame('Fair', $password_strength->getText());

    $password_field->setValue('abcABC123!sss');
    self::assertSame('Strong', $password_strength->getText());
  }

}
