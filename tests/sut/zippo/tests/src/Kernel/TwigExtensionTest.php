<?php

namespace Drupal\Tests\zippo\Kernel;

use Drupal\KernelTests\KernelTestBase;

/**
 * Twig extension test.
 *
 * @group DCG
 */
class TwigExtensionTest extends KernelTestBase {

  /**
   * {@inheritdoc}
   */
  public static $modules = ['zippo', 'example'];

  /**
   * Test callback.
   */
  public function testTwigExtension() {

    $template = \implode([
      '{{ foo("example") }}',
      '{{ "-=bar=-"|bar }}',
      '{{ "#123" is color }}',
      '{{ "example" is color }}',
    ]);

    $build = [
      '#type' => 'inline_template',
      '#template' => $template,
    ];

    $output = $this
      ->container
      ->get('renderer')
      ->renderRoot($build);

    static::assertEquals('Foo: example-=BAR=-10', $output);
  }

}
