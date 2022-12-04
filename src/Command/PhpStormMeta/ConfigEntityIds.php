<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Command\PhpStormMeta;

use Drupal\Core\Config\Entity\ConfigEntityTypeInterface;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use DrupalCodeGenerator\Asset\File;
use DrupalCodeGenerator\Utils;

/**
 * Generates PhpStorm meta-data for configuration entity types.
 */
final class ConfigEntityIds {

  /**
   * Constructs the object.
   */
  public function __construct(
    private readonly EntityTypeManagerInterface $entityTypeManager,
    private readonly \Closure $entityInterface,
  ) {}

  /**
   * Generator callback.
   */
  public function __invoke(): File {
    $entity_definitions = \array_filter(
      $this->entityTypeManager->getDefinitions(),
      static fn (EntityTypeInterface $entity_type): bool => $entity_type instanceof ConfigEntityTypeInterface,
    );
    \ksort($entity_definitions);

    $definitions = [];
    foreach ($entity_definitions as $type => $entity_definition) {
      /** @psalm-var array<string, string> $ids */
      $ids = $this->entityTypeManager
        ->getStorage($type)
        ->getQuery()
        ->accessCheck(FALSE)
        ->execute();
      if (\count($ids) > 0) {
        $definitions[] = [
          'type' => $type,
          'label' => $entity_definition->getLabel(),
          'class' => Utils::addLeadingSlash($entity_definition->getClass()),
          'interface' => ($this->entityInterface)($entity_definition),
          'ids' => \array_values($ids),
        ];
      }
    }

    return File::create('.phpstorm.meta.php/config_entity_ids.php')
      ->template('config_entity_ids.php.twig')
      ->vars(['definitions' => $definitions]);
  }

}
