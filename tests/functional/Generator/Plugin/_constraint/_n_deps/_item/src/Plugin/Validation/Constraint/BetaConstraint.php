<?php

declare(strict_types=1);

namespace Drupal\foo\Plugin\Validation\Constraint;

use Drupal\Core\StringTranslation\TranslatableMarkup;
use Drupal\Core\Validation\Attribute\Constraint;
use Symfony\Component\Validator\Constraint as SymfonyConstraint;

/**
 * Provides a Beta constraint.
 *
 * @DCG
 * To apply this constraint on third party field types. Implement
 * hook_field_info_alter() as follows.
 * @code
 * function foo_field_info_alter(array &$info): void {
 *   $info['FIELD_TYPE']['constraints']['FooBeta'] = [];
 * }
 * @endcode
 *
 * @see https://www.drupal.org/node/2015723
 */
#[Constraint(
  id: 'FooBeta',
  label: new TranslatableMarkup('Beta', options: ['context' => 'Validation'])
)]
final class BetaConstraint extends SymfonyConstraint {

  public string $message = '@todo Specify error message here.';

}
