<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Command\PhpStormMeta;

use Drupal\Core\Entity\EntityTypeBundleInfoInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use DrupalCodeGenerator\Asset\File;
use DrupalCodeGenerator\Utils;

/**
 * Generates PhpStorm meta-data for entity bundles.
 */
final class EntityBundles {

  /**
   * Constructs the object.
   */
  public function __construct(
    private readonly EntityTypeManagerInterface $entityTypeManager,
    private readonly EntityTypeBundleInfoInterface $entityTypeBundleInfo,
    private readonly \Closure $entityInterface,
  ) {}

  /**
   * Generator callback.
   */
  public function __invoke(): File {
    $definitions = [];
    $entity_definitions = $this->entityTypeManager->getDefinitions();
    \ksort($entity_definitions);
    $bundle_getters = [
      'node' => 'getType',
      'comment' => 'getTypeId',
    ];
    foreach ($entity_definitions as $entity_type_id => $entity_definition) {
      $definitions[] = [
        'type' => $entity_type_id,
        'label' => $entity_definition->getLabel(),
        'class' => Utils::addLeadingSlash($entity_definition->getClass()),
        'interface' => ($this->entityInterface)($entity_definition),
        'bundle_getter' => $bundle_getters[$entity_type_id] ?? NULL,
        'bundles' => \array_keys($this->entityTypeBundleInfo->getBundleInfo($entity_type_id)),
      ];
    }

    return File::create('.phpstorm.meta.php/entity_bundles.php')
      ->template('entity_bundles.php.twig')
      ->vars(['definitions' => $definitions]);
  }

}
