<?php declare(strict_types = 1);

namespace Drupal\foo\Plugin\Validation\Constraint;

use Drupal\Core\Field\FieldItemListInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * Validates the Gamma constraint.
 */
final class GammaConstraintValidator extends ConstraintValidator {

  /**
   * {@inheritdoc}
   */
  public function validate(mixed $items, Constraint $constraint): void {
    if (!$items instanceof FieldItemListInterface) {
      throw new \InvalidArgumentException(
        sprintf('The validated value must be instance of \Drupal\Core\Field\FieldItemListInterface, %s was given.', get_debug_type($items))
      );
    }
    foreach ($items as $delta => $item) {
      // @todo Validate the item list here.
      if ($item->value === 'wrong') {
        $this->context->buildViolation($constraint->message)
          ->atPath($delta)
          ->addViolation();
      }
    }
  }

}
