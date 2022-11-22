<?php declare(strict_types = 1);

namespace Drupal\foo\Plugin\Validation\Constraint;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * Validates the Alpha constraint.
 */
final class AlphaConstraintValidator extends ConstraintValidator {

  /**
   * {@inheritdoc}
   */
  public function validate(mixed $value, Constraint $constraint): void {
    // @todo Validate the value here.
    if ($value === 'wrong') {
      $this->context->addViolation($constraint->message);
    }
  }

}
