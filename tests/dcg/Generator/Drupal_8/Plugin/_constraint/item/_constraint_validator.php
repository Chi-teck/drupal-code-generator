<?php

namespace Drupal\foo\Plugin\Validation\Constraint;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * Validates the Gamma constraint.
 */
class GammaConstraintValidator extends ConstraintValidator {

  /**
   * {@inheritdoc}
   */
  public function validate($item, Constraint $constraint) {

    $value = $item->getValue()['value'];
    // @DCG Validate the value here.
    if ($value == 'foo') {
      $this->context->addViolation($constraint->errorMessage);
    }

  }

}
