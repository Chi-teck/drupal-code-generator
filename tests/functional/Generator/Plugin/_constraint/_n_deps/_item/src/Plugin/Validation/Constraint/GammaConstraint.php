<?php declare(strict_types = 1);

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
 * hook_field_info_alter() as follows.
 * @code
 * function foo_field_info_alter(array &$info): void {
 *   $info['FIELD_TYPE']['constraints']['FooGamma'] = [];
 * }
 * @endcode
 *
 * @see https://www.drupal.org/node/2015723
 */
final class GammaConstraint extends Constraint {

  public string $message = '@todo Specify error message here.';

}
