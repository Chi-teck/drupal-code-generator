<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Attribute;

use DrupalCodeGenerator\GeneratorType;

/**
 * Generator definition.
 */
#[\Attribute(\Attribute::TARGET_CLASS)]
final class Generator {

  public function __construct(
    public string $name,
    public ?string $description = NULL,
    public array $aliases = [],
    public bool $hidden = FALSE,
    public ?string $templatePath = NULL,
    public GeneratorType $type = GeneratorType::OTHER,
    public ?string $label = NULL,
  ) {}

}
