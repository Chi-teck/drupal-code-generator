<?php declare(strict_types=1);

namespace DrupalCodeGenerator;

/**
 * Generator definition.
 */
final class GeneratorDefinition {

  public function __construct(
    readonly public GeneratorType $type,
    readonly public string $templatePath,
    readonly public ?string $label,
  ) {}

}
