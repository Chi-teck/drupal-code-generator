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

  public function isNewExtension(): bool {
    return $this === self::MODULE || $this === self::THEME;
  }

  public function getNameLabel(): string {
    return match ($this) {
      self::MODULE, self::MODULE_COMPONENT => 'Module name',
      self::THEME, self::THEME_COMPONENT => 'Theme name',
      default => 'Name',
    };
  }

  public function getMachineNameLabel(): string {
    return match ($this) {
      self::MODULE, self::MODULE_COMPONENT => 'Module machine name',
      self::THEME, self::THEME_COMPONENT => 'Theme machine name',
      default => 'Machine name',
    };
  }

}
