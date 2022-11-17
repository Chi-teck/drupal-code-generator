<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Command\PhpStormMeta;

use DrupalCodeGenerator\Asset\File;
use DrupalCodeGenerator\Helper\Drupal\PermissionInfo;

/**
 * Generates PhpStorm meta-data for permissions.
 */
final class Permissions {

  /**
   * Constructs the object.
   */
  public function __construct(
    private readonly PermissionInfo $permissionInfo,
  ) {}

  /**
   * Generator callback.
   */
  public function __invoke(): File {
    $permissions = $this->permissionInfo->getPermissionNames();
    return File::create('.phpstorm.meta.php/permissions.php')
      ->template('permissions.php.twig')
      ->vars(['permissions' => $permissions]);
  }

}
