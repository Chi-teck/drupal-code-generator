<?php

namespace Drupal\foo\Plugin\Validation\Constraint;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * Validates the Delta constraint.
 */
class DeltaConstraintValidator extends ConstraintValidator {

  /**
   * {@inheritdoc}
   */
  public function validate($value, Constraint $constraint) {

    // @DCG Validate the value here.
    if ($value == 'foo') {
      $this->context->addViolation($constraint->errorMessage);
    }

  }

}
