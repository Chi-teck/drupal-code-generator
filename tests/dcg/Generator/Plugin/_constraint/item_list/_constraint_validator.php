<?php

namespace Drupal\foo\Plugin\Validation\Constraint;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * Validates the Beta constraint.
 */
class BetaConstraintValidator extends ConstraintValidator {

  /**
   * {@inheritdoc}
   */
  public function validate($items, Constraint $constraint) {

    foreach ($items as $delta => $item) {
      // @DCG Validate the item here.
      if ($item->value == 'foo') {
        $this->context->buildViolation($constraint->errorMessage)
          ->atPath($delta)
          ->addViolation();
      }
    }

  }

}
