<?php

declare(strict_types=1);

namespace DrupalCodeGenerator\Command\PhpStormMeta;

use Drupal\Core\Entity\EntityTypeManagerInterface;
use DrupalCodeGenerator\Asset\File;

/**
 * Generates PhpStorm meta-data for roles.
 */
final class Roles {

  /**
   * Constructs the object.
   */
  public function __construct(
    private readonly EntityTypeManagerInterface $entityTypeManager,
  ) {}

  /**
   * Generator callback.
   */
  public function __invoke(): File {
    // @todo Create a helper for roles.
    $roles = $this->entityTypeManager->getStorage('user_role')->loadMultiple();
    return File::create('.phpstorm.meta.php/roles.php')
      ->template('roles.php.twig')
      ->vars(['roles' => \array_keys($roles)]);
  }

}
