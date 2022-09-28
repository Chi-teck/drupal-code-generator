<?php declare(strict_types = 1);

namespace Drupal\foo;

use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Extension\ModuleUninstallValidatorInterface;
use Drupal\Core\StringTranslation\StringTranslationTrait;

/**
 * Prevents uninstalling of modules providing used block plugins.
 */
final class ExampleUninstallValidator implements ModuleUninstallValidatorInterface {

  use StringTranslationTrait;

  /**
   * The entity type manager.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * Constructs a new ExampleUninstallValidator object.
   */
  public function __construct(EntityTypeManagerInterface $entity_type_manager) {
    $this->entityTypeManager = $entity_type_manager;
  }

  /**
   * {@inheritdoc}
   */
  public function validate($module): array {
    $reasons = [];
    if ($module === 'foo') {
      $reasons[] = $this->t('Some good reason.');
    }
    return $reasons;
  }

}
