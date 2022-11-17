<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Command\PhpStormMeta;

use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Field\FieldTypePluginManagerInterface;
use DrupalCodeGenerator\Asset\File;

/**
 * Generates PhpStorm meta-data for field definitions.
 */
final class FieldDefinitions {

  /**
   * Constructs the object.
   */
  public function __construct(
    private readonly EntityTypeManagerInterface $entityTypeManager,
    private readonly FieldTypePluginManagerInterface $fieldTypePluginManager,
  ) {}

  /**
   * Generator callback.
   */
  public function __invoke(): File {
    $entity_types = \array_keys($this->entityTypeManager->getDefinitions());
    \sort($entity_types);
    $field_types = \array_keys($this->fieldTypePluginManager->getDefinitions());
    \sort($field_types);

    return File::create('.phpstorm.meta.php/field_definitions.php')
      ->template('field_definitions.php.twig')
      ->vars(['entity_types' => $entity_types, 'field_types' => $field_types]);
  }

}
