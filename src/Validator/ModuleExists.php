<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Validator;

use DrupalCodeGenerator\Helper\Drupal\ModuleInfo;

/**
 * Validates that the module with a given name exists.
 */
final class ModuleExists {

  /**
   * Constructs the object.
   */
  public function __construct(
    private readonly ModuleInfo $moduleInfo,
  ) {}

  /**
   * @throws \UnexpectedValueException
   */
  public function __invoke(string $value): string {
    if (!\array_key_exists($value, $this->moduleInfo->getExtensions())) {
      throw new \UnexpectedValueException('Module does not exists.');
    }
    return $value;
  }

}
