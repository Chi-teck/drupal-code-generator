<?php

declare(strict_types=1);

namespace Drupal\Tests\qux\Kernel\Plugin\migrate\source;

/**
 * Tests no-SQL source migrate plugin.
 *
 * 'Covers' annotation is required for this test.
 *
 * @see \Drupal\Tests\migrate\Kernel\MigrateSourceTestBase::getPluginClass
 *
 * @covers \Drupal\qux\Plugin\migrate\source\Bar
 *
 * @todo Enable this test by adding 'extends MigrateSourceTestBase' once we drop
 * support for Drupal 10.2
 */
final class BarTest {

  /**
   * {@inheritdoc}
   */
  protected static $modules = ['qux'];

  /**
   * {@inheritdoc}
   */
  public static function providerSource(): array {
    $tests = [];

    $tests[0]['source_data'] = [];
    $tests[0]['expected_data'][] = [
      'id' => 1,
      'name' => 'Alpha',
      'status' => TRUE,
    ];
    $tests[0]['expected_data'][] = [
      'id' => 2,
      'name' => 'Beta',
      'status' => FALSE,
    ];
    $tests[0]['expected_data'][] = [
      'id' => 3,
      'name' => 'Gamma',
      'status' => TRUE,
    ];
    $tests[0]['expected_count'] = 3;

    return $tests;
  }

}
