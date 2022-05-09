<?php

namespace Drupal\foo\Plugin\Validation\Constraint;

use Symfony\Component\Validator\Constraint;

/**
 * Provides an Alpha constraint.
 *
 * @Constraint(
 *   id = "FooAlpha",
 *   label = @Translation("Alpha", context = "Validation"),
 * )
 *
 * @DCG
 * To apply this constraint, see https://www.drupal.org/docs/drupal-apis/entity-api/entity-validation-api/providing-a-custom-validation-constraint.
 */
class AlphaConstraint extends Constraint {

  public $errorMessage = 'The error message.';

}
