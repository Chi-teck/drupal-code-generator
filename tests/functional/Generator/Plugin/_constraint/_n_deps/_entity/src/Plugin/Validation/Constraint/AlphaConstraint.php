<?php declare(strict_types = 1);

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
 * @see https://www.drupal.org/node/2015723.
 */
final class AlphaConstraint extends Constraint {

  public string $message = '@todo Specify error message here.';

}
