<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Asset;

/**
 * Resolver action.
 *
 * Defines possible actions that can be taken when an asset with the same path
 * already exists in the file system.
 *
 * @phpcs:disable
 * @todo Enable code sniffer once it supports enums
 * @see https://www.drupal.org/project/coder/issues/3283741
 */
enum ResolverAction {

  case REPLACE;
  case PREPEND;
  case APPEND;
  case SKIP;

}
