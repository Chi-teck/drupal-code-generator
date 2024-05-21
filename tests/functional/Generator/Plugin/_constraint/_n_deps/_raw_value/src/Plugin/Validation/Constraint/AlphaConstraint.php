<?php

declare(strict_types=1);

namespace Drupal\foo\Plugin\Validation\Constraint;

use Drupal\Core\StringTranslation\TranslatableMarkup;
use Drupal\Core\Validation\Attribute\Constraint;
use Symfony\Component\Validator\Constraint as SymfonyConstraint;

/**
 * Provides an Alpha constraint.
 */
#[Constraint(
  id: 'FooAlpha',
  label: new TranslatableMarkup('Alpha', options: ['context' => 'Validation'])
)]
final class AlphaConstraint extends SymfonyConstraint {

  public string $message = '@todo Specify error message here.';

}
