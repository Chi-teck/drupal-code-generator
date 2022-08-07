<?php declare(strict_types = 1);

namespace Drupal\foo\Annotation;

use Drupal\Component\Annotation\Plugin;

/**
 * Defines bar annotation object.
 *
 * @Annotation
 */
final class Bar extends Plugin {

  /**
   * The plugin ID.
   */
  public readonly string $id;

  /**
   * The human-readable name of the plugin.
   *
   * @ingroup plugin_translatable
   */
  public readonly string $title;

  /**
   * The description of the plugin.
   *
   * @ingroup plugin_translatable
   */
  public readonly string $description;

}
