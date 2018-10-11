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
 * To apply this constraint on a particular field implement
 * hook_entity_type_build().
 */
class AlphaConstraint extends Constraint {

  public $errorMessage = 'The error message.';

}
