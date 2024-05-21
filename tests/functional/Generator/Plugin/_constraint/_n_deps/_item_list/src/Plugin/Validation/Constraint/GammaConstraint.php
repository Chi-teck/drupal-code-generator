<?php

declare(strict_types=1);

namespace Drupal\foo\Plugin\Validation\Constraint;

use Drupal\Core\StringTranslation\TranslatableMarkup;
use Drupal\Core\Validation\Attribute\Constraint;
use Symfony\Component\Validator\Constraint as SymfonyConstraint;

/**
 * Provides a Gamma constraint.
 *
 * @DCG
 * To apply this constraint on third party entity types implement either
 * hook_entity_base_field_info_alter() or hook_entity_bundle_field_info_alter().
 *
 * @see https://www.drupal.org/node/2015723
 */
#[Constraint(
  id: 'FooGamma',
  label: new TranslatableMarkup('Gamma', options: ['context' => 'Validation'])
)]
final class GammaConstraint extends SymfonyConstraint {

  public string $message = '@todo Specify error message here.';

}
