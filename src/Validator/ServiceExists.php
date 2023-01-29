<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Validator;

use DrupalCodeGenerator\Helper\Drupal\ServiceInfo;

/**
 * Validates that service with a given name exists.
 */
final class ServiceExists {

  /**
   * Constructs the object.
   */
  public function __construct(
    private readonly ServiceInfo $serviceInfo,
  ) {}

  /**
   * @throws \UnexpectedValueException
   */
  public function __invoke(string $value): string {
    if (!$this->serviceInfo->getServiceDefinition($value)) {
      throw new \UnexpectedValueException('Service does not exists.');
    }
    return $value;
  }

}
