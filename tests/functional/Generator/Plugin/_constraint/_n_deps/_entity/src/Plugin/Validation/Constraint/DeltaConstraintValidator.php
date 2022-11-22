<?php declare(strict_types = 1);

namespace Drupal\foo\Plugin\Validation\Constraint;

use Drupal\Core\Entity\EntityInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * Validates the Delta constraint.
 */
final class DeltaConstraintValidator extends ConstraintValidator {

  /**
   * {@inheritdoc}
   */
  public function validate(mixed $entity, Constraint $constraint): void {
    if (!$entity instanceof EntityInterface) {
      throw new \InvalidArgumentException(
        sprintf('The validated value must be instance of \Drupal\Core\Entity\EntityInterface, %s was given.', get_debug_type($entity))
      );
    }
    // @todo Validate the entity here.
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
