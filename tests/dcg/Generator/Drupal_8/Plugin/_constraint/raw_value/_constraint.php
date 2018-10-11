<?php

namespace Drupal\foo\Plugin\Validation\Constraint;

use Symfony\Component\Validator\Constraint;

/**
 * Provides a Delta constraint.
 *
 * @Constraint(
 *   id = "FooDelta",
 *   label = @Translation("Delta", context = "Validation"),
 * )
 */
class DeltaConstraint extends Constraint {

  public $errorMessage = 'The error message.';

}
