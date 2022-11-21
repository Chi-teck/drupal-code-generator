<?php declare(strict_types = 1);

namespace Drupal\foo\Plugin\Validation\Constraint;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * Validates the Beta constraint.
 */
final class BetaConstraintValidator extends ConstraintValidator {

  /**
   * {@inheritdoc}
   */
  public function validate($items, Constraint $constraint): void {
    /** @var \Drupal\Core\TypedData\Plugin\DataType\ItemList $items */
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
