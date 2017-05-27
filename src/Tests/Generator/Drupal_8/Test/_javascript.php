<?php

namespace Drupal\Tests\foo\FunctionalJavascript;

use Drupal\FunctionalJavascriptTests\JavascriptTestBase;

/**
 * Tests the JavaScript functionality of the Foo module.
 *
 * @group foo
 */
class ExampleTest extends JavascriptTestBase {

  /**
   * {@inheritdoc}
   *
   * @DCG: Optional.
   */
  public static $modules = [];

  /**
   * Tests password strength widget.
   */
  public function testLogin() {
    $admin_user = $this->drupalCreateUser();
    $this->drupalLogin($admin_user);

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

    $this->createScreenshot(DRUPAL_ROOT . '/../output/debug.jpg');
  }

}
