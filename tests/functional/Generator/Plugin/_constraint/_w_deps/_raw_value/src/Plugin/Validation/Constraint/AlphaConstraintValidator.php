<?php declare(strict_types = 1);

namespace Drupal\foo\Plugin\Validation\Constraint;

use Drupal\Core\Database\Connection;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * Validates the Alpha constraint.
 */
final class AlphaConstraintValidator extends ConstraintValidator implements ContainerFactoryPluginInterface {

  /**
   * Constructs the object.
   */
  public function __construct(
    array $configuration,
    $plugin_id,
    $plugin_definition,
    private readonly Connection $connection,
  ) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition): self {
    return new self(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('database'),
    );
  }

  /**
   * {@inheritdoc}
   */
  public function validate(mixed $value, Constraint $constraint): void {
    // @todo Validate the value here.
    if ($value === 'wrong') {
      $this->context->addViolation($constraint->message);
    }
  }

}
