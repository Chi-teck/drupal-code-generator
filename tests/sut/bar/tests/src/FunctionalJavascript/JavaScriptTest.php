<?php

declare(strict_types=1);

namespace Drupal\Tests\bar\FunctionalJavascript;

use Drupal\FunctionalJavascriptTests\WebDriverTestBase;
use PHPUnit\Framework\Attributes\Group;

/**
 * Tests the generate JavaScript file..
 */
#[Group('DCG')]
final class JavaScriptTest extends WebDriverTestBase {

  /**
   * {@inheritdoc}
   */
  protected $defaultTheme = 'claro';

  /**
   * {@inheritdoc}
   */
  protected static $modules = ['bar'];

  /**
   * Test callback.
   */
  public function testJavascript(): void {
    // The `attach` method is evaluated as empty object.
    $result = $this->getSession()->evaluateScript('Drupal.behaviors.barHeavyMetal.attach');
    self::assertSame([], $result);

    // Checking console.log() output is tricky. So we basically test that the
    // call for `attach()` method does not through JS exceptions.
    $result = $this->getSession()->evaluateScript('Drupal.behaviors.barHeavyMetal.attach()');
    self::assertNull($result);
  }

}
