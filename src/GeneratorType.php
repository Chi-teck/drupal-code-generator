<?php declare(strict_types=1);

namespace DrupalCodeGenerator;

/**
 * Generator definition.
 *
 * @phpcs:disable
 * @todo Enable code sniffer once it supports enums
 * @see https://www.drupal.org/project/coder/issues/3283741
 */
enum GeneratorType {

  case MODULE;
  case MODULE_COMPONENT;
  case THEME;
  case THEME_COMPONENT;
  case OTHER;

}
