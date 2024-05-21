<?php

declare(strict_types=1);

namespace Drupal\foo\Plugin\Validation\Constraint;

use Drupal\Core\StringTranslation\TranslatableMarkup;
use Drupal\Core\Validation\Attribute\Constraint;
use Symfony\Component\Validator\Constraint as SymfonyConstraint;

/**
 * Provides a Delta constraint.
 *
 * @see https://www.drupal.org/node/2015723.
 */
#[Constraint(
  id: 'FooDelta',
  label: new TranslatableMarkup('Delta', options: ['context' => 'Validation'])
)]
final class DeltaConstraint extends SymfonyConstraint {

  public string $message = '@todo Specify error message here.';

}
