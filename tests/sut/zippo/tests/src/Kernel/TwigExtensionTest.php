<?php

declare(strict_types=1);

namespace Drupal\Tests\zippo\Kernel;

use Drupal\KernelTests\KernelTestBase;

/**
 * Twig extension test.
 *
 * @group DCG
 */
final class TwigExtensionTest extends KernelTestBase {

  /**
   * {@inheritdoc}
   */
  protected static $modules = ['zippo', 'example'];

  /**
   * Test callback.
   */
  public function testTwigExtension(): void {

    $build = [
      '#type' => 'inline_template',
      '#template' => <<< 'TXT'
        {{ example('foo') }}
        {{ '-=example=-'|example }}
        {{ 'example' is example ? 'Yes' : 'No' }}
        {{ 'not_example' is example ? 'Yes' : 'No' }}
        TXT,
    ];

    $output = (string) $this
      ->container
      ->get('renderer')
      ->renderRoot($build);

    $expected_output = <<< 'TXT'
      Example: foo
      -=EXAMPLE=-
      Yes
      No
      TXT;
    self::assertSame($expected_output, $output);
  }

}
