<?php

namespace Drupal\Tests\foo\Kernel;

use Drupal\KernelTests\KernelTestBase;

/**
 * Test description.
 *
 * @group foo
 */
class ExampleTest extends KernelTestBase {

  /**
   * {@inheritdoc}
   */
  public static $modules = ['foo'];

  /**
   * {@inheritdoc}
   */
  protected function setUp() {
    parent::setUp();
    // Mock required services here.
  }

  /**
   * Test callback.
   */
  public function testSomething() {
    $result = $this->container->get('transliteration')->transliterate('Друпал');
    $this->assertEquals('Drupal', $result);
  }

}
