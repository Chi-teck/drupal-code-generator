<?php declare(strict_types = 1);

namespace Drupal\example\Plugin\migrate\process;

use Drupal\migrate\MigrateExecutableInterface;
use Drupal\migrate\ProcessPluginBase;
use Drupal\migrate\Row;

/**
 * Provides an example_qux plugin.
 *
 * Usage:
 *
 * @code
 * process:
 *   bar:
 *     plugin: example_qux
 *     source: foo
 * @endcode
 *
 * @MigrateProcessPlugin(id = "example_qux")
 */
final class Qux extends ProcessPluginBase {

  /**
   * {@inheritdoc}
   */
  public function transform($value, MigrateExecutableInterface $migrate_executable, Row $row, $destination_property): mixed {
    // @todo Transform the value here.
    return $value;
  }

}
