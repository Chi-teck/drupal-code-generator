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
  public static $modules = ['foo'];

  /**
   * {@inheritdoc}
   */
  protected function setUp() {
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

    $this->assertEquals('', $password_strength->getText());

    $password_field->setValue('abc');
    $this->assertEquals('Weak', $password_strength->getText());

    $password_field->setValue('abcABC123!');
    $this->assertEquals('Fair', $password_strength->getText());

    $password_field->setValue('abcABC123!sss');
    $this->assertEquals('Strong', $password_strength->getText());
  }

}
