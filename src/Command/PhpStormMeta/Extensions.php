<?php

declare(strict_types=1);

namespace DrupalCodeGenerator\Command\PhpStormMeta;

use Drupal\Core\Extension\Extension;
use Drupal\Core\Extension\ModuleHandlerInterface;
use Drupal\Core\Extension\ThemeHandlerInterface;
use DrupalCodeGenerator\Asset\File;

/**
 * Generates PhpStorm meta-data for extensions.
 */
final class Extensions {

  /**
   * Constructs the object.
   */
  public function __construct(
    private readonly ModuleHandlerInterface $moduleHandler,
    private readonly ThemeHandlerInterface $themeHandler,
  ) {}

  /**
   * Generator callback.
   */
  public function __invoke(): File {
    // Module handler also manages profiles.
    $module_extensions = \array_filter(
      $this->moduleHandler->getModuleList(),
      static fn (Extension $extension): bool => $extension->getType() === 'module',
    );
    $modules = \array_keys($module_extensions);
    $themes = \array_keys($this->themeHandler->listInfo());
    \sort($themes);

    return File::create('.phpstorm.meta.php/extensions.php')
      ->template('extensions.php.twig')
      ->vars(['modules' => $modules, 'themes' => $themes]);
  }

}
