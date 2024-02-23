<?php

declare(strict_types=1);

namespace DrupalCodeGenerator\Helper\Drupal;

use Drupal\Core\Extension\Extension;

/**
 * A helper that provides information about installed Drupal extensions.
 */
interface ExtensionInfoInterface {

  /**
   * Returns a list of currently installed extensions.
   */
  public function getExtensions(): array;

  /**
   * Returns a human name of the extension.
   */
  public function getExtensionName(string $machine_name): ?string;

  /**
   * Returns a machine name of the extension.
   */
  public function getExtensionMachineName(string $name): ?string;

  /**
   * Returns destination for generated extension code.
   */
  public function getDestination(string $machine_name, bool $is_new): ?string;

  /**
   * Gets extension info for a given absolute path.
   */
  public function getExtensionFromPath(string $path): ?Extension;

}
