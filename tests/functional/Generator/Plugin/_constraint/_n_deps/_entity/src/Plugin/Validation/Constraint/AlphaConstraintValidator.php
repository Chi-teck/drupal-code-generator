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
  public function validate($entity, Constraint $constraint): void {
    // @todo Validate the entity here.
    /** @var \Drupal\Core\Entity\EntityInterface $entity */
    if ($entity->label() === 'wrong') {
      // @DCG Use the following code to bind the violation to a specific field.
      // @code
      // $this->context->buildViolation($constraint->message)
      //   ->atPath('field_example')
      //   ->addViolation();
      // @endcode
      $this->context->addViolation($constraint->message);
    }
  }

}
