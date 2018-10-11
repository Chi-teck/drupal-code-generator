<?php

namespace Drupal\foo\Plugin\Validation\Constraint;

use Symfony\Component\Validator\Constraint;

/**
 * Provides a Gamma constraint.
 *
 * @Constraint(
 *   id = "FooGamma",
 *   label = @Translation("Gamma", context = "Validation"),
 * )
 *
 * @DCG
 * To apply this constraint on third party field types. Implement
 * hook_field_info_alter().
 */
class GammaConstraint extends Constraint {

  public $errorMessage = 'The error message.';

}
