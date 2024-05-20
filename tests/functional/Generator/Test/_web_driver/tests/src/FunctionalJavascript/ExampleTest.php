<?php

declare(strict_types=1);

namespace Drupal\Tests\foo\FunctionalJavascript;

use Drupal\FunctionalJavascriptTests\WebDriverTestBase;
use PHPUnit\Framework\Attributes\Group;

/**
 * Tests the JavaScript functionality of the Foo module.
 */
#[Group('foo')]
final class ExampleTest extends WebDriverTestBase {

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
    // @todo Set up the test here or remove this method.
  }

  /**
   * Test callback.
   */
  public function testSomething(): void {
    // Place your code here.
  }

}
