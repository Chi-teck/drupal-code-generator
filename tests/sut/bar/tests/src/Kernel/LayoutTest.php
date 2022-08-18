<?php

namespace Drupal\Tests\bar\Kernel;

use Drupal\KernelTests\KernelTestBase;

/**
 * Layout test.
 *
 * @group DCG
 */
final class LayoutTest extends KernelTestBase {

  /**
   * {@inheritdoc}
   */
  protected static $modules = ['bar', 'layout_discovery'];

  /**
   * Test callback.
   */
  public function testTemplateRendering(): void {

    /** @var \Drupal\Core\Layout\LayoutInterface $layout */
    $layout = $this->container->get('plugin.manager.core.layout')
      ->createInstance('bar_foo');

    $regions = [
      'main' => ['#markup' => 'Main content'],
      'sidebar' => ['#markup' => 'Sidebar content'],
    ];
    $build = $layout->build($regions);

    self::assertSame($build['#attached']['library'], ['bar/foo']);

    $expected_output = <<< 'HTML'

        
      <div class="layout layout--foo">

              <div  class="layout__region layout__region--main">
            Main content
          </div>
        
              <div  class="layout__region layout__region--sidebar">
            Sidebar content
          </div>
        
      </div>


    HTML;

    $output = (string) $this->container->get('renderer')->renderRoot($build);
    self::assertSame($expected_output, $output);

    $expected_definition = [
      'js' => [
        [
          'group' => -100,
          'type' => 'file',
          'data' => 'modules/bar/layouts/foo/foo.js',
          'version' => -1,
          'minified' => FALSE,
        ],
      ],
      'css' => [
        [
          'weight' => 0,
          'group' => 0,
          'type' => 'file',
          'data' => 'modules/bar/layouts/foo/foo.css',
          'version' => -1,
        ],
      ],
      'dependencies' => [],
      'license' => [
        'name' => 'GNU-GPL-2.0-or-later',
        'url' => 'https://www.drupal.org/licensing/faq',
        'gpl-compatible' => TRUE,
      ],
    ];
    $definition = $this->container->get('library.discovery')
      ->getLibraryByName('bar', 'foo');
    self::assertSame($expected_definition, $definition);
  }

}
