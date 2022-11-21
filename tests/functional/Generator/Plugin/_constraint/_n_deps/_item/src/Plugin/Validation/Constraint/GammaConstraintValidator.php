<?php declare(strict_types = 1);

namespace Drupal\foo\Plugin\Validation\Constraint;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * Validates the Gamma constraint.
 */
final class GammaConstraintValidator extends ConstraintValidator {

  /**
   * {@inheritdoc}
   */
  public function validate($item, Constraint $constraint): void {
    /** @var \Drupal\Core\Field\FieldItemInterface $item */
    $value = $item->getValue()['value'];
    // @todo Validate the item value here.
    if ($value === 'wrong') {
      $this->context->addViolation($constraint->message);
    }
  }

}
