<?php declare(strict_types = 1);

namespace Drupal\foo;

use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Extension\ModuleUninstallValidatorInterface;
use Drupal\Core\StringTranslation\StringTranslationTrait;

/**
 * @todo Add validator description here.
 */
final class ExampleUninstallValidator implements ModuleUninstallValidatorInterface {

  use StringTranslationTrait;

  /**
   * Constructs the object.
   */
  public function __construct(
    private readonly EntityTypeManagerInterface $entityTypeManager,
  ) {}

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
