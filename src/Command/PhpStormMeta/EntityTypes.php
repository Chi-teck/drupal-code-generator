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
    $entity_types = [];
    $handlers['storages'] = [];
    $handlers['view_builders'] = [];
    $handlers['list_builders'] = [];
    $handlers['access_controls'] = [];
    $handlers['classes'] = [];
    $definitions = $this->entityTypeManager->getDefinitions();
    \ksort($definitions);
    foreach ($definitions as $type => $definition) {
      $entity_types[] = $type;
      $handlers['classes'][] = Utils::addLeadingSlash($definition->getClass());
      $handlers['storages'][$type] = Utils::addLeadingSlash($definition->getStorageClass());
      $handlers['access_controls'][$type] = Utils::addLeadingSlash($definition->getAccessControlClass());
      if ($definition->hasViewBuilderClass()) {
        $handlers['view_builders'][$type] = Utils::addLeadingSlash($definition->getViewBuilderClass());
      }
      if ($definition->hasListBuilderClass()) {
        $handlers['list_builders'][$type] = Utils::addLeadingSlash($definition->getListBuilderClass());
      }
    }

    return File::create('.phpstorm.meta.php/entity_types.php')
      ->template('entity_types.php.twig')
      ->vars(['handlers' => $handlers, 'entity_types' => $entity_types]);
  }

}
