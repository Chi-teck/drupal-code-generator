<?php declare(strict_types = 1);

namespace Drupal\foo\Plugin\Validation\Constraint;

use Symfony\Component\Validator\Constraint;

/**
 * Provides a Beta constraint.
 *
 * @Constraint(
 *   id = "FooBeta",
 *   label = @Translation("Beta", context = "Validation"),
 * )
 *
 * @DCG
 * To apply this constraint on third party entity types implement either
 * hook_entity_base_field_info_alter() or hook_entity_bundle_field_info_alter().
 *
 * @see https://www.drupal.org/node/2015723
 */
final class BetaConstraint extends Constraint {

  public string $message = '@todo Specify error message here.';

}
