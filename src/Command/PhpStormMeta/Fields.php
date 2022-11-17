<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Command\PhpStormMeta;

use Drupal\Core\Entity\EntityFieldManagerInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Entity\FieldableEntityInterface;
use DrupalCodeGenerator\Asset\File;
use DrupalCodeGenerator\Utils;

/**
 * Generates PhpStorm meta-data for entity fields.
 */
final class Fields {

  /**
   * Constructs the object.
   */
  public function __construct(
    private readonly EntityTypeManagerInterface $entityTypeManager,
    private readonly EntityFieldManagerInterface $entityFieldManager,
    private readonly \Closure $entityInterface,
  ) {}

  /**
   * Generator callback.
   */
  public function __invoke(): File {
    $definitions = [];
    foreach ($this->entityTypeManager->getDefinitions() as $entity_type => $definition) {
      if (!$definition->entityClassImplements(FieldableEntityInterface::class)) {
        continue;
      }
      $definitions[] = [
        'type' => $entity_type,
        'label' => $definition->getLabel(),
        'class' => Utils::addLeadingSlash($definition->getClass()),
        'interface' => ($this->entityInterface)($definition),
        'fields' => \array_keys($this->entityFieldManager->getFieldStorageDefinitions($entity_type)),
      ];
    }

    return File::create('.phpstorm.meta.php/fields.php')
      ->template('fields.php.twig')
      ->vars(['definitions' => $definitions]);
  }

}
