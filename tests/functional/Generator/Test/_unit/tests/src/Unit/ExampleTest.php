<?php declare(strict_types = 1);

namespace Drupal\Tests\foo\Unit;

use Drupal\Tests\UnitTestCase;

/**
 * Test description.
 *
 * @group foo
 */
final class ExampleTest extends UnitTestCase {

  /**
   * {@inheritdoc}
   */
  protected function setUp(): void {
    parent::setUp();
    // @todo Mock required classes here.
  }

  /**
   * Tests something.
   */
  public function testSomething(): void {
    self::assertTrue(TRUE, 'This is TRUE!');
  }

}
