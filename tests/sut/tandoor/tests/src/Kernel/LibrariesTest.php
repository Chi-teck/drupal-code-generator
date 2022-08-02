<?php declare(strict_types = 1);

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
                'data' => 'themes/azalea/css/components/block.css',
                'version' => -1,
              ],
              [
                'weight' => 0,
                'group' => 100,
                'type' => 'file',
                'data' => 'themes/azalea/css/components/breadcrumb.css',
                'version' => -1,
              ],
              [
                'weight' => 0,
                'group' => 100,
                'type' => 'file',
                'data' => 'themes/azalea/css/components/field.css',
                'version' => -1,
              ],
              [
                'weight' => 0,
                'group' => 100,
                'type' => 'file',
                'data' => 'themes/azalea/css/components/form.css',
                'version' => -1,
              ],
              [
                'weight' => 0,
                'group' => 100,
                'type' => 'file',
                'data' => 'themes/azalea/css/components/header.css',
                'version' => -1,
              ],
              [
                'weight' => 0,
                'group' => 100,
                'type' => 'file',
                'data' => 'themes/azalea/css/components/menu.css',
                'version' => -1,
              ],
              [
                'weight' => 0,
                'group' => 100,
                'type' => 'file',
                'data' => 'themes/azalea/css/components/messages.css',
                'version' => -1,
              ],
              [
                'weight' => 0,
                'group' => 100,
                'type' => 'file',
                'data' => 'themes/azalea/css/components/node.css',
                'version' => -1,
              ],
              [
                'weight' => 0,
                'group' => 100,
                'type' => 'file',
                'data' => 'themes/azalea/css/components/sidebar.css',
                'version' => -1,
              ],
              [
                'weight' => 0,
                'group' => 100,
                'type' => 'file',
                'data' => 'themes/azalea/css/components/table.css',
                'version' => -1,
              ],
              [
                'weight' => 0,
                'group' => 100,
                'type' => 'file',
                'data' => 'themes/azalea/css/components/tabs.css',
                'version' => -1,
              ],
              [
                'weight' => 0,
                'group' => 100,
                'type' => 'file',
                'data' => 'themes/azalea/css/components/buttons.css',
                'version' => -1,
              ],
              [
                'weight' => -100,
                'group' => 100,
                'type' => 'file',
                'data' => 'themes/azalea/css/layouts/layout.css',
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
              'name' => 'GNU-GPL-2.0-or-later',
              'url' => 'https://www.drupal.org/licensing/faq',
              'gpl-compatible' => TRUE,
            ],
        ],
    ];
  }

}
