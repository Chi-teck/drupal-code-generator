<?php

declare(strict_types=1);

namespace Drupal\Tests\qux\Kernel;

use Drupal\KernelTests\KernelTestBase;
use Drupal\Tests\node\Traits\NodeCreationTrait;
use Drupal\views\Entity\View;
use PHPUnit\Framework\Attributes\Group;

/**
 * Tests views style plugin.
 */
#[Group('DCG')]
final class ViewStyleTest extends KernelTestBase {

  use NodeCreationTrait;

  /**
   * {@inheritdoc}
   */
  protected static $modules = [
    'qux',
    'system',
    'user',
    'views',
    'node',
    'filter',
  ];

  /**
   * {@inheritdoc}
   */
  public function setUp(): void {
    parent::setUp();
    $this->installEntitySchema('user');
    $this->installEntitySchema('node');
    $this->installConfig('filter');
    $this->installConfig('editor');
    $this->installConfig('qux');
    $this->createNode(['title' => 'Hello world!']);
  }

  /**
   * Test callback.
   */
  public function testPlugin(): void {
    $this->assertWrapperClass('item-list');

    // Change wrapper class.
    $view = View::load('qux_example');
    $display = &$view->getDisplay('default');
    $display['display_options']['style']['options']['wrapper_class'] = 'foo';
    $view->save();

    $this->assertWrapperClass('foo');
  }

  /**
   * Asserts that the view output has correct wrapper class.
   */
  protected function assertWrapperClass(string $wrapper_class): void {
    $build = \views_embed_view('qux_example');
    $output = $this->container->get('renderer')->renderRoot($build);
    $xml = new \SimpleXMLElement((string) $output);
    $xpath = \sprintf('//div/div[@class = "%s"]/div//a[text() = "Hello world!"]', $wrapper_class);
    self::assertCount(1, $xml->xpath($xpath));
  }

}
