<?php

declare(strict_types=1);

namespace Drupal\foo\Plugin\Validation\Constraint;

use Symfony\Component\Validator\Constraint;

/**
 * Provides a Delta constraint.
 *
 * @Constraint(
 *   id = "FooDelta",
 *   label = @Translation("Delta", context = "Validation"),
 * )
 *
 * @see https://www.drupal.org/node/2015723.
 */
final class DeltaConstraint extends Constraint {

  public string $message = '@todo Specify error message here.';

}
