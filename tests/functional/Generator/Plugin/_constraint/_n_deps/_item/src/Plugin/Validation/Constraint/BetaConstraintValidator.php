<?php declare(strict_types = 1);

namespace Drupal\foo\Plugin\Validation\Constraint;

use Drupal\Core\Field\FieldItemInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * Validates the Beta constraint.
 */
final class BetaConstraintValidator extends ConstraintValidator {

  /**
   * {@inheritdoc}
   */
  public function validate(mixed $item, Constraint $constraint): void {
    if (!$item instanceof FieldItemInterface) {
      throw new \InvalidArgumentException(
        sprintf('The validated value must be instance of \Drupal\Core\Field\FieldItemInterface, %s was given.', get_debug_type($item))
      );
    }
    // @todo Validate the item value here.
    if ($item->value === 'wrong') {
      $this->context->addViolation($constraint->message);
    }
  }

}
