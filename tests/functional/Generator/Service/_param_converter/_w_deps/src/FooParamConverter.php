<?php

declare(strict_types=1);

namespace Drupal\example;

use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\ParamConverter\ParamConverterInterface;
use Symfony\Component\Routing\Route;

/**
 * @todo Add description for the converter.
 *
 * @DCG
 * To use this converter specify parameter type in a relevant route as follows:
 * @code
 * example.foo_parameter_converter:
 *   path: example/{record}
 *   defaults:
 *     _controller: '\Drupal\example\Controller\ExampleController::build'
 *   requirements:
 *     _access: 'TRUE'
 *   options:
 *     parameters:
 *       record:
 *        type: foo
 * @endcode
 *
 * Note that parameter converter for entities already exists in Drupal core.
 * @see \Drupal\Core\ParamConverter\EntityConverter
 */
final class FooParamConverter implements ParamConverterInterface {

  /**
   * Constructs a FooParamConverter object.
   */
  public function __construct(
    private readonly EntityTypeManagerInterface $entityTypeManager,
  ) {}

  /**
   * {@inheritdoc}
   */
  public function convert($value, $definition, $name, array $defaults): ?string {
    // @DCG
    // If the converter returns something different rather than strings make
    // sure to define an appropriate return type for this method.
    return match ($value) {
      '1' => 'alpha',
      '2' => 'beta',
      '3' => 'gamma',
      // NULL will trigger 404 HTTP error.
      default => NULL,
    };
  }

  /**
   * {@inheritdoc}
   */
  public function applies($definition, $name, Route $route): bool {
    return isset($definition['type']) && $definition['type'] === 'example';
  }

}
