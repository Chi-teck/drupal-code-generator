<?php

namespace Drupal\Tests\qux\Kernel;

use Drupal\KernelTests\KernelTestBase;
use Drupal\Tests\node\Traits\NodeCreationTrait;
use Drupal\views\Entity\View;

/**
 * Tests views style plugin.
 *
 * @group DCG
 */
class ViewStyleTest extends KernelTestBase {

  use NodeCreationTrait;

  /**
   * {@inheritdoc}
   */
  public static $modules = ['qux', 'system', 'user', 'views', 'node', 'filter'];

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    parent::setUp();
    $this->installEntitySchema('user');
    $this->installEntitySchema('node');
    $this->installConfig('filter');
    $this->installConfig('qux');
    $this->createNode(['title' => 'Hello world!']);
  }

  /**
   * Test callback.
   */
  public function testPlugin() {

    self::assertWrapperClass('item-list');

    // Change wrapper class.
    $view = View::load('qux_example');
    $display = &$view->getDisplay('default');
    $display['display_options']['style']['options']['wrapper_class'] = 'foo';
    $view->save();

    self::assertWrapperClass('foo');
  }

  /**
   * Asserts that the view output has correct wrapper class.
   */
  protected static function assertWrapperClass($wrapper_class) {
    $build = views_embed_view('qux_example');
    $output = \Drupal::service('renderer')->renderRoot($build);
    $xml = new \SimpleXMLElement($output);
    $xpath = sprintf('//div/div[@class = "%s"]/div//a[text() = "Hello world!"]', $wrapper_class);
    self::assertCount(1, $xml->xpath($xpath));
  }

}
