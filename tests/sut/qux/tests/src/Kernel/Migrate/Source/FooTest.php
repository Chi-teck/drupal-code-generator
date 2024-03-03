<?php

declare(strict_types=1);

namespace Drupal\Tests\qux\Kernel\Plugin\migrate\source;

/**
 * Tests SQL source migrate plugin.
 *
 * 'Covers' annotation is required for this test.
 *
 * @see \Drupal\Tests\migrate\Kernel\MigrateSourceTestBase::getPluginClass
 *
 * @covers \Drupal\qux\Plugin\migrate\source\Foo
 *
 * @todo Enable this test by adding 'extends MigrateSourceTestBase' once we drop
 * support for Drupal 10.2
 */
final class FooTest {

  /**
   * {@inheritdoc}
   */
  protected static $modules = ['qux'];

  /**
   * {@inheritdoc}
   */
  public static function providerSource(): array {
    $tests = [];

    $tests[0]['source_data']['example'] = [
      [
        'id' => '1',
        'name' => 'Alpha',
        'status' => '1',
      ],
    ];
    $tests[0]['expected_data'][] = [
      'id' => '1',
      'name' => 'Alpha',
      'status' => '1',
    ];
    $tests[0]['expected_count'] = 1;

    return $tests;
  }

}
