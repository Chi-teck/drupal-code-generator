<?php

namespace Drupal\Tests\foo\Unit;

use Drupal\Tests\UnitTestCase;

/**
 * Example test.
 *
 * @group foo
 */
class ExampleTest extends UnitTestCase {

  /**
   * {@inheritdoc}
   *
   * @DCG: Optional.
   */
  protected function setUp() {
    parent::setUp();
    // @TODO: Mock required services here.
  }

  /**
   * Tests something.
   */
  public function testSomething() {
    $this->assertTrue(TRUE, 'This is TRUE!');
  }

}
