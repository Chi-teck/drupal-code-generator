<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Attribute;

use DrupalCodeGenerator\GeneratorType;

/**
 * Generator definition.
 */
#[\Attribute(\Attribute::TARGET_CLASS)]
final class Generator {

  public function __construct(
    public readonly string $name,
    public readonly string $description = '',
    public readonly array $aliases = [],
    public readonly bool $hidden = FALSE,
    public readonly ?string $templatePath = NULL,
    public readonly GeneratorType $type = GeneratorType::OTHER,
    public readonly ?string $label = NULL,
  ) {}

}
