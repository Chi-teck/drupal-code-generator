<?php

declare(strict_types=1);

namespace Drupal\Tests\tandoor\Kernel;

use Drupal\KernelTests\KernelTestBase;

/**
 * Tests library definitions.
 *
 * @group DCG
 */
final class LibrariesTest extends KernelTestBase {

  /**
   * {@inheritdoc}
   */
  protected function setUp(): void {
    parent::setUp();
    $this->container->get('theme_installer')->install(['azalea']);
  }

  /**
   * Test callback.
   */
  public function testLibraries(): void {
    // @todo Remove this once we drop support for Drupal 10.2.
    if (\version_compare(\Drupal::VERSION, '10.3', '<')) {
      self::markTestSkipped();
    }
    $libraries = $this->container->get('library.discovery')
      ->getLibrariesByExtension('azalea');
    self::assertSame(self::getExpectedLibraries(), $libraries);
  }

  /**
   * Returns expected library definitions.
   */
  private static function getExpectedLibraries(): array {
    return [
      'global' =>
        [
          'js' =>
            [
              [
                'group' => -100,
                'type' => 'file',
                'data' => 'themes/azalea/js/azalea.js',
                'version' => -1,
                'minified' => FALSE,
              ],
            ],
          'css' =>
            [
              [
                'weight' => -200,
                'group' => 100,
                'type' => 'file',
                'data' => 'themes/azalea/css/base/elements.css',
                'version' => -1,
              ],
              [
                'weight' => 0,
                'group' => 100,
                'type' => 'file',
                'data' => 'themes/azalea/css/component/block.css',
                'version' => -1,
              ],
              [
                'weight' => 0,
                'group' => 100,
                'type' => 'file',
                'data' => 'themes/azalea/css/component/breadcrumb.css',
                'version' => -1,
              ],
              [
                'weight' => 0,
                'group' => 100,
                'type' => 'file',
                'data' => 'themes/azalea/css/component/field.css',
                'version' => -1,
              ],
              [
                'weight' => 0,
                'group' => 100,
                'type' => 'file',
                'data' => 'themes/azalea/css/component/form.css',
                'version' => -1,
              ],
              [
                'weight' => 0,
                'group' => 100,
                'type' => 'file',
                'data' => 'themes/azalea/css/component/header.css',
                'version' => -1,
              ],
              [
                'weight' => 0,
                'group' => 100,
                'type' => 'file',
                'data' => 'themes/azalea/css/component/menu.css',
                'version' => -1,
              ],
              [
                'weight' => 0,
                'group' => 100,
                'type' => 'file',
                'data' => 'themes/azalea/css/component/messages.css',
                'version' => -1,
              ],
              [
                'weight' => 0,
                'group' => 100,
                'type' => 'file',
                'data' => 'themes/azalea/css/component/node.css',
                'version' => -1,
              ],
              [
                'weight' => 0,
                'group' => 100,
                'type' => 'file',
                'data' => 'themes/azalea/css/component/sidebar.css',
                'version' => -1,
              ],
              [
                'weight' => 0,
                'group' => 100,
                'type' => 'file',
                'data' => 'themes/azalea/css/component/table.css',
                'version' => -1,
              ],
              [
                'weight' => 0,
                'group' => 100,
                'type' => 'file',
                'data' => 'themes/azalea/css/component/tabs.css',
                'version' => -1,
              ],
              [
                'weight' => 0,
                'group' => 100,
                'type' => 'file',
                'data' => 'themes/azalea/css/component/buttons.css',
                'version' => -1,
              ],
              [
                'weight' => -100,
                'group' => 100,
                'type' => 'file',
                'data' => 'themes/azalea/css/layout/layout.css',
                'version' => -1,
              ],
              [
                'media' => 'print',
                'weight' => 200,
                'group' => 100,
                'type' => 'file',
                'data' => 'themes/azalea/css/theme/print.css',
                'version' => -1,
              ],
            ],
          'dependencies' => [],
          'license' =>
            [
              'name' => 'GPL-2.0-or-later',
              'url' => 'https://www.drupal.org/licensing/faq',
              'gpl-compatible' => TRUE,
            ],
        ],
    ];
  }

}
