<?php

declare(strict_types=1);

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
 * To apply this constraint on third party entity types implement either
 * hook_entity_base_field_info_alter() or hook_entity_bundle_field_info_alter().
 *
 * @see https://www.drupal.org/node/2015723
 */
final class GammaConstraint extends Constraint {

  public string $message = '@todo Specify error message here.';

}
