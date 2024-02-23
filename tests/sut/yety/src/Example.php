<?php

declare(strict_types=1);

namespace Drupal\yety;

use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;

/**
 * Sample service for testing services.yml generator.
 */
final class Example {

  /**
   * The constructor.
   */
  public function __construct(
    private readonly EntityTypeManagerInterface $entityTypeManager,
  ) {}

  /**
   * Gets entity definition.
   *
   * That would allow to test that the correct dependency was injected.
   */
  public function getDefinition(string $definition): EntityTypeInterface {
    return $this->entityTypeManager->getDefinition($definition);
  }

}
