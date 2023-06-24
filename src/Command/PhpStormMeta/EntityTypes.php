<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Command\PhpStormMeta;

use Drupal\Core\Entity\EntityTypeManagerInterface;
use DrupalCodeGenerator\Asset\File;
use DrupalCodeGenerator\Utils;

/**
 * Generates PhpStorm meta-data for entity types.
 */
final class EntityTypes {

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
    $normalized_definitions = [];
    foreach ($this->entityTypeManager->getDefinitions() as $type => $definition) {
      $normalized_definitions[$type]['class'] = self::normalizeType($definition->getClass());
      $normalized_definitions[$type]['storage'] = self::normalizeType($definition->getStorageClass());
      $normalized_definitions[$type]['access_control'] = self::normalizeType($definition->getAccessControlClass());
      $normalized_definitions[$type]['list_builder'] = self::normalizeType($definition->getListBuilderClass());
      $normalized_definitions[$type]['view_builder'] = self::normalizeType($definition->getViewBuilderClass());
    }
    \ksort($normalized_definitions);
    return File::create('.phpstorm.meta.php/entity_types.php')
      ->template('entity_types.php.twig')
      ->vars(['definitions' => $normalized_definitions]);
  }

  /**
   * Normalizes handler type.
   */
  private static function normalizeType(?string $class): ?string {
    if ($class === NULL) {
      return NULL;
    }
    $class = Utils::addLeadingSlash($class);
    /** @psalm-var class-string $interface */
    $interface = $class . 'Interface';
    return \is_a($class, $interface, TRUE) ? $interface : $class;
  }

}
