<?php

namespace Drupal\foo\Plugin\Validation\Constraint;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * Validates the Alpha constraint.
 */
class AlphaConstraintValidator extends ConstraintValidator {

  /**
   * {@inheritdoc}
   */
  public function validate($entity, Constraint $constraint) {

    // @DCG Validate the entity here.
    if ($entity->label() == 'foo') {
      $this->context->buildViolation($constraint->errorMessage)
        // @DCG The path depends on entity type. It can be title, name, etc.
        ->atPath('title')
        ->addViolation();
    }

  }

}
