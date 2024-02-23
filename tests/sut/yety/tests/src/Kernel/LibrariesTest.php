<?php

declare(strict_types=1);

namespace Drupal\Tests\yety\Kernel;

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
  protected static $modules = ['yety'];

  /**
   * Test callback.
   */
  public function testLibraries(): void {
    $libraries = $this->container->get('library.discovery')
      ->getLibrariesByExtension('yety');
    self::assertSame(self::getExpectedLibraries(), $libraries);
  }

  /**
   * Returns expected library definitions.
   */
  private static function getExpectedLibraries(): array {
    return [
      'example_1' =>
        [
          'js' => [
            [
              'group' => -100,
              'type' => 'file',
              'data' => 'modules/yety/js/example-1.js',
              'version' => -1,
              'minified' => FALSE,
            ],
          ],
          'css' => [
            [
              'weight' => 0,
              'group' => 0,
              'type' => 'file',
              'data' => 'modules/yety/css/example-1.css',
              'version' => -1,
            ],
          ],
          'dependencies' => [
            'core/drupalSettings',
            'yety/example_2',
          ],
          'license' => [
            'name' => 'GNU-GPL-2.0-or-later',
            'url' => 'https://www.drupal.org/licensing/faq',
            'gpl-compatible' => TRUE,
          ],
        ],
      'example_2' => [
        'remote' => 'https://example.com',
        'version' => '1.0.0',
        'license' => [
          'name' => 'MIT',
          'url' => 'https://github.com/example/example-2/path/to/LICENSE',
          'gpl-compatible' => TRUE,
        ],
        'js' => [
          [
            'group' => -100,
            'type' => 'file',
            'data' => 'libraries/example-2/source/example-2.js',
            'version' => '1.0.0',
            'minified' => FALSE,
          ],
        ],
        'css' => [
          [
            'weight' => 0,
            'group' => 0,
            'type' => 'file',
            'data' => 'libraries/example-2/source/example-2.css',
            'version' => '1.0.0',
          ],
        ],
        'dependencies' => ['core/jquery'],
      ],
      'example_3' => [
        'remote' => 'https://example.com',
        'version' => '1.0.0',
        'license' => [
          'name' => 'MIT',
          'url' => 'https://github.com/example/example-3/path/to/LICENSE',
          'gpl-compatible' => TRUE,
        ],
        'js' => [
          [
            'type' => 'external',
            'minified' => TRUE,
            'group' => -100,
            'data' => 'https://cdnjs.cloudflare.com/ajax/libs/example/1.0.0/example-3.min.js',
            'version' => '1.0.0',
          ],
        ],
        'dependencies' => [],
        'css' => [],
      ],
    ];
  }

}
